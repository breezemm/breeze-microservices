<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Event;

class EventCommentController extends Controller
{
    public function __invoke(Event $event, CreateCommentRequest $createCommentReqeust)
    {

        $data = [
            'notification_id' => 'post_commented',
            'user_id' => $event->user->id,
            'notification' => [
                'title' => 'New Follower',
                'body' => auth()->user()->name . ' comments on your post',
            ],
            'data' => [
                'user' => auth()->user()->with('media')->first(),
                'post_id' => $event->id,
            ],
        ];

        $event->comments()->create([
            'comment' => $createCommentReqeust->comment,
            'user_id' => auth()->id(),
            'parent_id' => $createCommentReqeust->parent_id ?? null,
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
        ], 201);
    }
}
