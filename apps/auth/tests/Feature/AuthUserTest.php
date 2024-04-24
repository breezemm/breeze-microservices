<?php

use App\Models\User;
use Laravel\Passport\Passport;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});


it('return a 403 return when user is not logged in', function () {
    $response = $this->get('/api/v1/auth/me', [
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(401);
});
