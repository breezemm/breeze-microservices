<?php

namespace MyanmarCyberYouths\BreezeSdk;

use League\Config\Configuration;
use MyanmarCyberYouths\BreezeSdk\Connectors\AuthConnector;
use Nette\Schema\Expect;

final readonly class Breeze
{
    private Configuration $config;

    public function __construct(
        public readonly string $accessToken = '',
        public readonly array $settings = [],
    ) {
        $this->config = new Configuration([
            'auth' => Expect::structure([
                'base_url' => Expect::string()->default('localhost'),
            ]),
        ]);
        $this->config->merge($this->settings);
    }

    public function auth(): AuthConnector
    {
        return new AuthConnector(
            accessToken: $this->accessToken,
            baseUrl: $this->config->get('auth.base_url'),
        );
    }
}
