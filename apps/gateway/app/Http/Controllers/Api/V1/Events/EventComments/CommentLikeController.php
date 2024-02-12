<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Actions\SendPushNotification;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;

class CommentLikeController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws \Exception
     */
    public function __invoke(Event $event, Comment $comment)
    {
        auth()->user()->like($comment);

        (new SendPushNotification())->handle([
            'notification_id' => 'comment_liked',
            'user' => [
                'user_id' => $comment->user->id,
            ],
            'channels' => [
                'push' => [
                    'title' => 'Comment Liked',
                    'body' => auth()->user()->name . ' likes your comment.',
                    'data' => [
                        'type' => 'comment_liked',
                        'user' => auth()->user()->with('media')->get(),
                        'content' => 'likes your comment.',
                    ]
                ]
            ]
        ]);
        return response()->json([
            'message' => 'Comment liked successfully',
            'data' => $comment->likers()->count(),
        ]);
    }
}
