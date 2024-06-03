<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class UnLikeCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Comment $comment)
    {
        $comment->commentLikes()->delete();
    }
}
