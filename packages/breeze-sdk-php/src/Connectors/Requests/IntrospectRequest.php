<?php

namespace MyanmarCyberYouths\BreezeSdk\Connectors\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class IntrospectRequest extends Request
{

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/oauth/introspect';
    }
}
