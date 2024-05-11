<?php

namespace MyanmarCyberYouths\RedisPubSub;

use MyanmarCyberYouths\RedisPubSub\Commands\StreamerWatchCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MyanmarCyberYouths\RedisPubSub\Commands\RedisPubSubCommand;

class RedisPubSubServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-redis-pub-sub')
            ->hasConfigFile(['streamer'])
            ->hasCommand(StreamerWatchCommand::class);
    }
}
