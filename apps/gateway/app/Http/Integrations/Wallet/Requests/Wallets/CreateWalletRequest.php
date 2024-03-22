<?php

namespace App\Http\Integrations\Wallet\Requests\Wallets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CreateWalletRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/example';
    }
}
