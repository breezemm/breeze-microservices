<?php

namespace MyanmarCyberYouths\Breeze;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use MyanmarCyberYouths\Breeze\Commands\BreezeCommand;
use MyanmarCyberYouths\Breeze\Connectors\Auth\AuthConnector;
use MyanmarCyberYouths\Breeze\Guards\AuthorizationGuard;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BreezeServiceProvider extends PackageServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $token = $this->app->make('request')->bearerToken();
        $this->app->singleton(AuthConnector::class, fn() => new AuthConnector(token: $token));

        Auth::extend('breeze.authorizer', function ($app, $name, array $config) {
            return new AuthorizationGuard();
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
