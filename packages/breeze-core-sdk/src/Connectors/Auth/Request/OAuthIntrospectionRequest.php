<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\Request;

use JsonException;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Data\OAuthIntrospectionData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class OAuthIntrospectionRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(public readonly string $token = '')
    {
    }

    public function resolveEndpoint(): string
    {
        return '/oauth/introspect';
    }

    protected function defaultQuery(): array
    {
        return [
            'token_type_hint' => 'access_token',
            'token' => $this->token,
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): OAuthIntrospectionData
    {
        $data = $response->object();

        return new OAuthIntrospectionData(
            active: $data->active,
            scopes: $data->scopes,
        );
    }

}
