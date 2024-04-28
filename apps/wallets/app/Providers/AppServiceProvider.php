<?php

namespace App\Providers;

use App\Contracts\AtomicLockInterface;
use App\Contracts\WalletServiceInterface;
use App\Services\AtomicLockService;
use App\Services\WalletService;
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
            WalletServiceInterface::class,
            WalletService::class
        );

        $this->app->bind(
            AtomicLockInterface::class,
            AtomicLockService::class
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
            }
        );
    }
}
