<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth;

use JsonException;
use Mockery\Exception;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Data\AuthenticatedUserData;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Request\GetAuthenticatedUserRequest;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Request\OAuthIntrospectionRequest;
use Saloon\Contracts\Authenticator;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;

class AuthConnector extends Connector
{
    public function __construct(
        public readonly string $token = '',
    ) {
    }

    public function resolveBaseUrl(): string
    {
        //        return 'http://localhost:8005/api/v1';
        return 'http://auth/api/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->token);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function introspect(): Response
    {
        return $this->send(new OAuthIntrospectionRequest($this->token));
    }

    public function check(): bool
    {
        try {
            $response = $this->introspect()->dto();

            return $response->active;
        } catch (Exception | FatalRequestException | RequestException) {
            return false;
        }
    }

    public function user(): ?AuthenticatedUserData
    {
        try {
            $response = $this->send(new GetAuthenticatedUserRequest());

            $data = $response->json('data');

            return new AuthenticatedUserData(
                id: $data['user']['id'],
                name: $data['user']['name'],
                username: $data['user']['username'],
                email: $data['user']['email'],
                profileImage: $data['user']['profile_image'],
                city: $data['user']['city'],
            );
        } catch (Exception | FatalRequestException | RequestException | JsonException) {
            return null;
        }
    }
}
