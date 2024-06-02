<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth;


use JsonException;
use Mockery\Exception;
use MyanmarCyberYouths\Breeze\Connectors\Auth\DataTransferObjects\AuthenticatedUser;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Request\GetAuthUserRequest;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Request\OAuthIntrospectionRequest;
use Saloon\Contracts\Authenticator;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

class AuthConnector extends Connector
{

    public function __construct(
        public readonly string $token = '',
    )
    {
    }

    public function resolveBaseUrl(): string
    {
        return 'auth/api/v1';
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
    public function introspect(): \Saloon\Http\Response
    {
        return $this->send(new OAuthIntrospectionRequest($this->token));
    }

    public function check(): bool
    {
        try {
            $response = $this->introspect();

            return $response->json('active');
        } catch (Exception|FatalRequestException|RequestException|JsonException) {
            return false;
        }
    }

    public function can(string $permission): bool
    {
        try {
            $response = $this->introspect();

            $scopes = $response->json('scope');

            return in_array($permission, $scopes);
        } catch (Exception|FatalRequestException|RequestException|JsonException) {
            return false;
        }
    }


    public function user(): ?AuthenticatedUser
    {
        try {
            $response = $this->send(new GetAuthUserRequest());

            $data = $response->json('data');

            return new AuthenticatedUser(
                id: $data['user']['id'],
                name: $data['user']['name'],
                username: $data['user']['username'],
                email: $data['user']['email'],
                profileImage: $data['user']['profile_image'],
                city: $data['user']['city'],
            );
        } catch (Exception|FatalRequestException|RequestException|JsonException) {
            return null;
        }
    }
}
