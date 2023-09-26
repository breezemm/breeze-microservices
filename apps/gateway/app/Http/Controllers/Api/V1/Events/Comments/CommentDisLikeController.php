<?php

namespace App\Http\Controllers\Api\V1\Events\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;

class CommentDisLikeController extends Controller
{
    public function __invoke(Event $event, Comment $comment)
    {
        auth()->user()->unlike($comment);

        return response()->json([
            'message' => 'Comment disliked successfully',
            'data' => $comment->likers()->count()
        ]);
    }
}
