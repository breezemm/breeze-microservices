<?php

namespace App\Console\Commands;

use App\Services\CommandHandler;
use App\Support\Payload;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;
use Junges\Kafka\Config\Sasl;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Exceptions\KafkaConsumerException;
use Junges\Kafka\Facades\Kafka;
use function Laravel\Prompts\password;

class WalletTopicConsumer extends Command
{
    protected $signature = 'kafka:wallet-consume';

    protected $description = 'Subscribe to wallet topic';

    /**
     * @throws Exception
     * @throws KafkaConsumerException
     */
    public function handle(): void
    {
        $consumer = Kafka::createConsumer()
//            ->withSasl(new Sasl(
//                username: env('KAFKA_USERNAME') ?? '',
//                password: env('KAFKA_PASSWORD') ?? '',
//                mechanisms: env('KAFKA_SASL_MECHANISMS') ?? '',
//                securityProtocol: env('KAFKA_SECURITY_PROTOCOL') ?? '',
//            ))
            ->subscribe('wallet')
            ->withHandler(function (KafkaConsumerMessage $message) {
                $this->info('[Received Command]: ' . $message->getBody());

                $payload = json_decode($message->getBody(), true);
                $commandHandler = new CommandHandler();
                $commandHandler->handle(new Payload(
                    id: $payload['id'],
                    topic: $payload['topic'],
                    pattern: $payload['pattern'],
                    data: $payload['data'],
                ));
            })
            ->withDlq('wallet-dlq')
            ->withAutoCommit()
            ->build();

        $consumer->consume();
    }
}
