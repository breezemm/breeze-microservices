<?php

namespace App\Http\Controllers\Api\V1\UserFollowings;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserUnFollowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'You cannot unfollow yourself',
            ], 400);
        }

        if (! auth()->user()->isFollowing($user)) {
            return response()->json([
                'message' => 'You are not following this user',
            ], 400);
        }

        auth()->user()->unfollow($user);

        return response()->json([
            'message' => 'User unfollowed successfully',
        ]);
    }
}
