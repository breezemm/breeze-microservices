<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;

class CommentLikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Event $event, Comment $comment)
    {
        auth()->user()->like($comment);

        $data = [
            'notification_id' => 'comment_liked',
            'user_id' => $event->user->id,
            'notification' => [
                'title' => 'New Follower',
                'body' => auth()->user()->name . ' liked your comment',
            ],
            'data' => [
                'user' => auth()->user()->with('media')->first(),
                'post_id' => $event->id,
            ],
        ];
        return response()->json([
            'message' => 'Comment liked successfully',
            'data' => $comment->likers()->count(),
        ]);
    }
}
