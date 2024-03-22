<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Http::macro('suggestion', fn () => Http::baseUrl(
            config('services.breeze.suggestion')
        ));

        Http::macro('wallets', fn () => Http::baseUrl(
            config('services.breeze.wallets')
        ));

        Http::macro('notification', fn () => Http::baseUrl(
            config('services.breeze.notifications')
        ));

    }
}
