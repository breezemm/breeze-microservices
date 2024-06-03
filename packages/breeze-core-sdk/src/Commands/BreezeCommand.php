<?php

namespace MyanmarCyberYouths\Breeze\Commands;

use Illuminate\Console\Command;

class BreezeCommand extends Command
{
    public $signature = 'breeze-core-sdk';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
