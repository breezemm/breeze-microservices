<?php

namespace App\Providers;

use App\Contracts\AtomicLockInterface;
use App\Contracts\WalletServiceInterface;
use App\Services\AtomicLockService;
use App\Services\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
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
}
