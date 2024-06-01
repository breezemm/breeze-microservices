<?php

namespace App\Providers;

use App\Common\AuthorizationGuard;
use App\Common\BreezeUserProvider;
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
        Auth::provider('breeze.oauth.provider', function ($app, array $config) {
            return new BreezeUserProvider();
        });

        Auth::extend('breeze.authorizer', function ($app, $name, array $config) {
            return new AuthorizationGuard(Auth::createUserProvider($config['provider']), $app['request']);
        });
    }
}
