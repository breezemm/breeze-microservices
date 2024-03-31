<?php

namespace App\Http\Integrations\Wallet\Requests\Wallets;

use App\DataTransferObjects\WalletData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateWallet extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly WalletData $createWalletData,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/wallets';
    }

    protected function defaultBody(): array
    {
        return $this->createWalletData->toArray();
    }
}
