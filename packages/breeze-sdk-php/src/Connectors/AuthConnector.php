<?php

namespace MyanmarCyberYouths\BreezeSdk\Connectors;

use InvalidArgumentException;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

class AuthConnector extends Connector
{

    public function __construct(public readonly string $token)
    {
    }


    public function resolveBaseUrl(): string
    {
        return 'auth/api/v1';
    }


    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->token);
    }
}
