<?php

namespace App\Http\Integrations;

use Saloon\Http\Connector;

class WalletServiceConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'http://wallets.test/api/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
