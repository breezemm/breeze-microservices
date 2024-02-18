<?php

namespace App\Http\Controllers\Api\V1\Posts\PostComments;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventCommentIndexController extends Controller
{
    public function __invoke(Event $event)
    {

        $event = $event->with('media')
            ->withCount('comments')
            ->withCount('likers')
            ->first();

        $comments = $event->comments()
            ->with('user.media')
            ->withCount('likers')
            ->withCount('replies')
            ->get()
            ->toTree('replies');

        return response()->json([
            'data' => [
                'event' => auth()->user()->attachLikeStatus($event),
                'comments' => auth()->user()->attachLikeStatus($comments),
            ],
        ]);
    }
}
