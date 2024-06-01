<?php

namespace App\Common;

use AllowDynamicProperties;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Requests\GetAuthUserRequest;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Requests\OAuthIntrospectionRequest;
use MyanmarCyberYouths\Breeze\Facades\Breeze;

#[AllowDynamicProperties] class AuthorizationGuard implements Guard
{

    public function __construct(
        public UserProvider $provider,
        public Request      $request
    )
    {
    }


    public function check()
    {
        try {
            $response = Breeze::auth()->send(new OAuthIntrospectionRequest($this->request->bearerToken()));

            return $response->json('active');
        } catch (Exception) {
            return false;
        }
    }

    public function guest()
    {
        // TODO: Implement guest() method.
    }

    public function user(): ?AuthUser
    {

        try {
            $response = Breeze::auth()->send(new GetAuthUserRequest());

            $data = $response->json('data');

            return new AuthUser(
                id: $data['user']['id'],
                name: $data['user']['name'],
                username: $data['user']['username'],
                email: $data['user']['email'],
                profileImage: $data['user']['profile_image'],
                city: $data['user']['city'],
            );
        } catch (Exception) {
            return null;
        }
    }


    public function id(): int|string|null
    {
        return $this->user()->id;
    }

    public function validate(array $credentials = [])
    {
    }

    public function hasUser()
    {
        return $this->check();
    }

    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
    }
}
