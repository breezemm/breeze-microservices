<?php

namespace App\Http\Integrations\Wallet\Requests\Wallets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetWalletById extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public readonly int $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/wallets/{$this->id}";
    }
}
