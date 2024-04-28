<?php

namespace MyanmarCyberYouths\BreezeSdk;

use InvalidArgumentException;
use MyanmarCyberYouths\BreezeSdk\Connectors\AuthConnector;

class Breeze
{
    public function __construct(
        public string $accessToken = '',
    ) {
        if (empty($this->accessToken)) {
            throw new InvalidArgumentException('Access Token is required for authentication.');
        }
    }

    public function auth(): AuthConnector
    {
        return new AuthConnector($this->accessToken);
    }
}
