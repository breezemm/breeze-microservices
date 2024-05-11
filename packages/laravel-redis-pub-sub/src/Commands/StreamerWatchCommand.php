<?php

namespace MyanmarCyberYouths\RedisPubSub\Commands;

use Illuminate\Console\Command;
use MyanmarCyberYouths\CommandWatcher\Contracts\ShouldWatch;

class StreamerWatchCommand extends Command implements ShouldWatch
{

    protected $signature = 'streamer:watch';

    protected $description = 'Watch redis stream events';


    public function shellCommand(): string
    {
        return 'php artisan streamer:listen --all';
    }
}
