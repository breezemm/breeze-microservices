<?php

namespace MyanmarCyberYouths\BreezeSdk\Connectors\Requests;

use MyanmarCyberYouths\BreezeSdk\Connectors\DataTransferObjects\OauthIntrospectResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class OAuthIntrospectRequest extends Request
{

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/oauth/introspect';
    }


    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();
        return new OauthIntrospectResponse(
            active: $data['active'],
        );
    }
}
