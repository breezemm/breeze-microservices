<?php

namespace App\Console\Commands;

use App\Kafka\KafkaCommandHandler;
use App\Support\Payload;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Commit\NativeSleeper;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Exceptions\KafkaConsumerException;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Handlers\RetryableHandler;
use Junges\Kafka\Handlers\RetryStrategies\DefaultRetryStrategy;

class WalletTopicConsumer extends Command
{
    protected $signature = 'consume:wallets';

    protected $description = 'Subscribe to the wallets topic';

    /**
     * @throws Exception
     * @throws KafkaConsumerException
     */
    public function handle(): void
    {

        $handler = function (KafkaConsumerMessage $message) {
            $this->info('[Received Command]: ' . $message->getBody());

            $payload = json_decode($message->getBody(), true);
            $commandHandler = new KafkaCommandHandler();
            $commandHandler->handle(new Payload(
                id: $payload['id'],
                topic: $payload['topic'],
                pattern: $payload['pattern'],
                data: $payload['data'],
            ));
        };
        $retryableHandler = new RetryableHandler($handler, new DefaultRetryStrategy(), new NativeSleeper());

        $consumer = Kafka::createConsumer()
            ->subscribe(config('kafka.topics'))
            ->withHandler($retryableHandler)
            ->withDlq(config('kafka.dlq'))
            ->withAutoCommit()
            ->build();


        $consumer->consume();
    }
}
