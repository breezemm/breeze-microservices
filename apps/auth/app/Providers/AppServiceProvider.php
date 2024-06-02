<?php

namespace App\Providers;

use App\Packages\OTP\OTP;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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

        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });

        $this->app->singleton(OTP::class, function () {
            return new OTP();
        });

        RateLimiter::for('otp', function (Request $request) {
            return Limit::perMinutes(decayMinutes: 2, maxAttempts: 1)->by($request->input('email'));
        });

    }
}
