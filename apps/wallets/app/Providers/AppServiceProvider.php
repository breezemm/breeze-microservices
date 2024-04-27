<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MyanmarCyberYouths\BreezeSdk\Breeze;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\WalletServiceInterface::class,
            \App\Services\WalletService::class
        );

        $this->app->bind(
            \App\Contracts\AtomicLockInterface::class,
            \App\Services\AtomicLockService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(
            Breeze::class,
            function () {
                return new Breeze(accessToken: 'dummy token');
            });
    }
}
