<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsumeWalletsTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume-wallets-topic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume wallets topic from kafka broker.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "Consuming wallets topic from kafka broker...\n";
    }
}
