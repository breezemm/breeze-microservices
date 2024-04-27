<?php

namespace MyanmarCyberYouths\BreezeSdk\Connectors\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetProfileRequest extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/me';
    }
}
