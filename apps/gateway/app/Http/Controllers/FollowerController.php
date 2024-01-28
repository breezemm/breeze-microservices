<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;

class FollowerController extends Controller
{
    public function __invoke(string $username)
    {
        try {
            $user = User::whereUsername($username)->firstOrFail();
            $followers = $user->followers;

            return response()->json([
                'data' => [
                    'followers_count' => $user->followers()->count(),
                    'followers' => UserResource::collection($followers),
                ],
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

    }
}
