<?php

namespace App\Http\Integrations\Wallet\Requests\Wallets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWalletByUserId extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/wallets/users/{$this->id}";
    }

    protected function defaultQuery(): array
    {
        return [
            'wallet_type' => 'PREPAID',
        ];
    }
}
