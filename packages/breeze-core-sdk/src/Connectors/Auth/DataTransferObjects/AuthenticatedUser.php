<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\DataTransferObjects;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class AuthenticatedUser extends Data implements Authenticatable
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
