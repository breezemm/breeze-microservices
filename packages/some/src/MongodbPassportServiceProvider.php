<?php

namespace Breeze\MongoDB;

use Breeze\MongoDB\Commands\ClientCommand;
use Breeze\MongoDB\Commands\InstallCommand;
use Breeze\MongoDB\Passport\AuthCode;
use Breeze\MongoDB\Passport\Bridge\RefreshTokenRepository;
use Breeze\MongoDB\Passport\Client;
use Breeze\MongoDB\Passport\PersonalAccessClient;
use Breeze\MongoDB\Passport\Token;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository as PassportRefreshTokenRepository;
use Laravel\Passport\Passport;

class MongodbPassportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::useClientModel(Client::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        Passport::useTokenModel(Token::class);

        $this->app->bind(PassportRefreshTokenRepository::class, function () {
            return $this->app->make(RefreshTokenRepository::class);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                ClientCommand::class,
            ]);
        }
    }
}
