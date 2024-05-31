<?php

namespace MyanmarCyberYouths\BreezeSdk;

use MyanmarCyberYouths\BreezeSdk\Connectors\AuthConnector;
use MyanmarCyberYouths\BreezeSdk\Connectors\Requests\OAuthIntrospectRequest;

final class Breeze
{

    public function __construct(
        public readonly string $token,
    )
    {
    }

    public function auth(): AuthConnector
    {
        return new AuthConnector($this->token);
    }
}
