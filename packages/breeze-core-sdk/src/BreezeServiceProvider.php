<?php

namespace MyanmarCyberYouths\Breeze;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use MyanmarCyberYouths\Breeze\Auth\TokenGuard;
use MyanmarCyberYouths\Breeze\Commands\BreezeCommand;
use MyanmarCyberYouths\Breeze\Connectors\Auth\AuthConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BreezeServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(AuthConnector::class, function (Application $app) {
            $token = $app->make('request')->bearerToken();

            return new AuthConnector(token: $token);
        });

        Auth::extend('breeze.authorizer', function ($app, $name, array $config) {
            return new TokenGuard();
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('breeze-core-sdk')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_breeze-core-sdk_table')
            ->hasCommand(BreezeCommand::class);
    }
}
