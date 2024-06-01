<?php

namespace App\Common;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Requests\OAuthIntrospectionRequest;
use MyanmarCyberYouths\Breeze\Facades\Breeze;

readonly class SSOGuard implements Guard
{

    public function __construct(
        public UserProvider $provider,
        public Request      $request
    )
    {
    }

    public function check()
    {
        $response = Breeze::auth()->send(new OAuthIntrospectionRequest($this->request->bearerToken()));

        return $response->json('active');
    }

    public function guest()
    {
        // TODO: Implement guest() method.
    }

    public function user()
    {
        $response = Breeze::auth()->send(new OAuthIntrospectionRequest($this->request->bearerToken()));

        return $response->json('active');
    }

    public function id()
    {
        // TODO: Implement id() method.
    }

    public function validate(array $credentials = [])
    {
        return false;
    }

    public function hasUser()
    {
        // TODO: Implement hasUser() method.
    }

    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
    }
}
