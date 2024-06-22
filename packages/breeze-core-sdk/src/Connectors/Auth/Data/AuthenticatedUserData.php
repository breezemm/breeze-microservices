<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\Data;

use Illuminate\Contracts\Auth\Authenticatable;
use JsonException;
use Mockery\Exception;
use MyanmarCyberYouths\Breeze\Connectors\Auth\AuthConnector;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class AuthenticatedUserData extends Data implements Authenticatable
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $username,
        public string $email,
        #[MapOutputName('profile_image')]
        public string $profileImage,
        public string $city,
    )
    {
    }

    public function tokenCan(array ...$scopes): bool
    {
        try {
            $response = app(AuthConnector::class)->introspect()->dto();
            $tokenScopes = $response->scopes;

            $flatScopes = array_merge(...$scopes);

            foreach ($flatScopes as $scope) {
                if (in_array($scope, $tokenScopes)) {
                    return true;
                }
            }

            return false;
        } catch (Exception|FatalRequestException|RequestException|JsonException) {
            return false;
        }
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPasswordName()
    {
        // TODO: Implement getAuthPasswordName() method.
    }

    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
