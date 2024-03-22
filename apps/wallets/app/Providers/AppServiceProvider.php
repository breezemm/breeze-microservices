<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
    }
}
