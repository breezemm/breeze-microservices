<?php

namespace App\Http\Controllers\Api\V1\Posts\PostReactions;

use App\Actions\SendPushNotification;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class PostLikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Event $event)
    {
        auth()->user()->like($event);

        (new SendPushNotification())->handle([
            'notification_id' => 'post_liked',
            'user' => [
                'user_id' => $event->user->id,
            ],
            'channels' => [
                'push' => [
                    'title' => 'Post Liked',
                    'body' => auth()->user()->name . ' likes your post.',
                    'data' => [
                        'type' => 'new_follower',
                        'user' => auth()->user()->load('media'),
                        'content' => 'likes your post.',
                    ]
                ]
            ]
        ]);


        return new JsonResponse([
            'message' => 'Event liked successfully',
            'data' => $event->likers()->count(),
        ]);
    }
}
