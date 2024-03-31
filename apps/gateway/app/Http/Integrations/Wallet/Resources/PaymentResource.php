<?php

namespace App\Http\Integrations\Wallet\Resources;

use App\DataTransferObjects\PaymentData;
use App\Http\Integrations\Wallet\Requests\Payments\CreatePaymentTransaction;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class PaymentResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function createPaymentTransaction(PaymentData $paymentData): Response
    {
        return $this->connector->send(new CreatePaymentTransaction($paymentData));
    }
}
