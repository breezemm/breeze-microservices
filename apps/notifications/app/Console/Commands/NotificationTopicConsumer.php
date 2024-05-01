<?php

namespace App\Console\Commands;

use App\Kafka\KafkaCommandHandler;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Exceptions\KafkaConsumerException;
use Junges\Kafka\Facades\Kafka;

class NotificationTopicConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume-notification-topic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from the notification topic';

    /**
     * Execute the console command.
     *
     * @throws KafkaConsumerException
     * @throws Exception
     */
    public function handle(): void
    {
        $consumer = Kafka::createConsumer()
            ->subscribe('notifications')
            ->withHandler(function (KafkaConsumerMessage $message) {
                print_r($message->getBody());

                KafkaCommandHandler::handle($message);
            })
            ->withDlq('notifications-dlq')
            ->withConsumerGroupId('notification-consumer-group')
            ->build();

        $consumer->consume();
    }
}
