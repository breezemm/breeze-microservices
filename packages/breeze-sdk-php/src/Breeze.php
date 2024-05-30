<?php

namespace MyanmarCyberYouths\BreezeSdk;

use MyanmarCyberYouths\BreezeSdk\Connectors\AuthConnector;

final readonly class Breeze
{

    public function __construct(
        public readonly string $accessToken = '',
        public readonly array $settings = [],
    ) {

    }

    public function auth(): AuthConnector
    {
        return new AuthConnector(
            accessToken: $this->accessToken,
            baseUrl: $this->config->get('auth.base_url'),
        );
    }
}
