<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\DataTransferObjects;

use Illuminate\Contracts\Auth\Authenticatable;

readonly class AuthenticatedUser implements Authenticatable
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $username,
        public string $email,
        public string $profileImage,
        public string $city,
    )
    {
    }
    public function id(): int
    {
        return $this->id;
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
