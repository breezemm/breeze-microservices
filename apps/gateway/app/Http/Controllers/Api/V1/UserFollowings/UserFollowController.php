<?php

namespace App\Http\Controllers\Api\V1\UserFollowings;

use App\Actions\SendPushNotification;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserFollowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws \Exception
     */
    public function __invoke(User $user)
    {

        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'You cannot follow yourself',
            ], 400);
        }

        if (auth()->user()->isFollowing($user)) {
            return response()->json([
                'message' => 'You are already following this user',
            ], 400);
        }

        auth()->user()->follow($user);

        (new SendPushNotification())->handle([
            'notification_id' => 'new_follower',
            'user' => [
                'user_id' => $user->id,
            ],
            'channels' => [
                'push' => [
                    'title' => 'New Follower',
                    'body' => auth()->user()->name.' follows you.',
                    'data' => [
                        'type' => 'new_follower',
                        'user' => auth()->user()->load('media'),
                        'content' => 'follows you.',
                    ],
                ],
            ],
        ]);

        return response()->json([
            'message' => 'User followed successfully',
        ]);
    }
}
