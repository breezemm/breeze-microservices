<?php

namespace App\Console\Commands;

use App\Jobs\KafkaJob;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:listen';

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
        $consumer = Kafka::consumer(['wallets'])
            ->withHandler(new KafkaJob())
            ->withAutoCommit()
            ->build();

        $consumer->consume();

    }
}
