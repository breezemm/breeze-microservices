<?php

namespace MyanmarCyberYouths\Breeze\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use MyanmarCyberYouths\Breeze\Connectors\Auth\AuthConnector;

class TokenGuard implements Guard
{
    use GuardHelper;

    public function check(): bool
    {
        return app(AuthConnector::class)->check();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    public function user(): Authenticatable|null
    {
        return app(AuthConnector::class)->user();
    }


    public function validate(array $credentials = [])
    {
    }

    public function hasUser(): bool
    {
        return $this->check();
    }

    public function setUser(Authenticatable $user)
    {
    }
}
