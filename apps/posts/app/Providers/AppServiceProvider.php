<?php

namespace App\Providers;

use App\Common\SSOGuard;
use App\Common\SSOProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('breeze-sso', function ($app, array $config) {
            return new SSOProvider();
        });

        Auth::extend('token', function ($app, $name, array $config) {
//            return new SSOGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
//            return new SSOGuard();

            return new SSOGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
    }
}
