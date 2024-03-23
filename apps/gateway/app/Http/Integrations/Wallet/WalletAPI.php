<?php

namespace App\Http\Integrations\Wallet;

use App\Http\Integrations\Wallet\Resources\PaymentResource;
use App\Http\Integrations\Wallet\Resources\WalletResource;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class WalletAPI extends Connector
{
    use AcceptsJson;

    public ?int $tries = 3;

    public ?int $retryInterval = 500;

    public ?bool $useExponentialBackoff = true;

    public function resolveBaseUrl(): string
    {
        return config('services.breeze.wallets');
    }

    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    public function wallets(): WalletResource
    {
        return new WalletResource($this);
    }

    public function payments(): PaymentResource
    {
        return new PaymentResource($this);
    }
}
