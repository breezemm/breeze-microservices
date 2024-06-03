<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\Request;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAuthenticatedUserRequest extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/auth/me';
    }


}
