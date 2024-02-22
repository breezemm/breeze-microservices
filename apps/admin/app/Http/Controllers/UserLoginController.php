<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        $validated = $loginRequest->validated();
        if (!auth()->attempt($validated)) {
            abort(401, 'Unauthorized');
        }


        $token = $loginRequest->user()->createToken('access_token')->plainTextToken;

        return response()->json([
            'data' => [
                'type' => 'Bearer',
                'access_token' => $token,
            ]
        ], 200);

    }
}
