<?php

namespace MyanmarCyberYouths\Breeze\Guards;

use AllowDynamicProperties;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use MyanmarCyberYouths\Breeze\Facades\Breeze;

#[AllowDynamicProperties] class AuthorizationGuard implements Guard
{
    public function check(): bool
    {
        return Breeze::auth()->check();
    }

    public function guest()
    {
        // TODO: Implement guest() method.
    }

    public function user(): Authenticatable|null
    {
        return Breeze::auth()->user();
    }


    public function id(): int|string|null
    {
        return $this->user()->id;
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
        // TODO: Implement setUser() method.
    }
}
