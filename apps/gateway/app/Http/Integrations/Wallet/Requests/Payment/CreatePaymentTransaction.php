<?php

namespace App\Http\Integrations\Wallet\Requests\Payment;

use App\DataTransferObjects\PaymentData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePaymentTransaction extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly PaymentData $paymentData,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/payments';
    }

    protected function defaultBody(): array
    {
        return $this->paymentData->toArray();
    }
}
