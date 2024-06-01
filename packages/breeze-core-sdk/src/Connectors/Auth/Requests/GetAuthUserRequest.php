<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAuthUserRequest extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/auth/me';
    }


}
