<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class TestTopicCommandCosumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume';

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
            ->subscribe('test-topic')
            ->withHandler(function (KafkaConsumerMessage $message) {
                $this->info('Received message: ' . $message->getBody());
            })
            ->withAutoCommit()
            ->build();

        $consumer->consume();
    }
}
