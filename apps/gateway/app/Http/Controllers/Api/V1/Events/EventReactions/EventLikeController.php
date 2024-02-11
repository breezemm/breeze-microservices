<?php

namespace App\Http\Controllers\Api\V1\Events\EventReactions;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventLikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Event $event)
    {
        auth()->user()->like($event);

        $data = [
            'notification_id' => 'post_liked',
            'user_id' => $event->user->id,
            'notification' => [
                'title' => 'New Follower',
                'body' => auth()->user()->name . ' likes your post',
            ],
            'data' => [
                'user' => auth()->user()->with('media')->first(),
                'post_id' => $event->id,
            ],
        ];

        return new JsonResponse([
            'message' => 'Event liked successfully',
            'data' => $event->likers()->count(),
        ]);
    }
}
