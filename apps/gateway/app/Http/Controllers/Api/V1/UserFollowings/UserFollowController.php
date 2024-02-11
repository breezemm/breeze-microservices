<?php

namespace App\Http\Controllers\Api\V1\UserFollowings;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserFollowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        auth()->user()->follow($user);

        $data = [
            'notification_id' => 'new_follower',
            'user_id' => $user->id,
            'notification' => [
                'title' => 'New Follower',
                'body' => auth()->user()->name . ' started following you',
            ],
            'data' => [
                'user' => auth()->user()->with('media')->first(),
            ],
        ];

        return response()->json([
            'message' => 'User followed successfully',
        ]);
    }
}
