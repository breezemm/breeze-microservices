<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserIdentifyRequest;
use App\Models\User;

class UserIdentifyController extends Controller
{
    public function create(UserIdentifyRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $user->update([
            'settings' => [
                'channels' => [
                    'email' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ],
                    'sms' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ],
                    'push' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ],
                    'web_push' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ]
                ]
            ]
        ]);

        return response()->json([
            'message' => 'User created successfully.',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function update(UserIdentifyRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($validated);
    }
}
