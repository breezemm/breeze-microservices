<?php

namespace App\Console\Commands;

use App\Events\WalletReceived;
use App\Jobs\CheckoutJob;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Exceptions\KafkaConsumerException;
use Junges\Kafka\Facades\Kafka;

class TestCommandConsumer extends Command
{
    protected $signature = 'kafka:test-consume';

    protected $description = 'Consume test messages from kafka';

    /**
     * @throws Exception
     * @throws KafkaConsumerException
     */
    public function handle()
    {
        $consumer = Kafka::createConsumer()
            ->subscribe('test-topic')
            ->withHandler(function (KafkaConsumerMessage $message) {
                $this->info('Received message: ' . $message->getBody());
                CheckoutJob::dispatch(
                    json_decode($message->getBody(), true)
                );
            })
            ->withAutoCommit()
            ->build();

        $consumer->consume();
    }
}
