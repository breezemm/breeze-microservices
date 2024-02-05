<?php

namespace App\Console\Commands;

use App\Kafka\KafkaCommandHandler;
use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class WalletConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume-wallets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $consumer = Kafka::createConsumer()
            ->subscribe('wallets')
            ->withHandler(function (KafkaConsumerMessage $message) {
                print_r($message->getBody());
                KafkaCommandHandler::handle($message);
            })
            ->build();

        $consumer->consume();
    }
}
