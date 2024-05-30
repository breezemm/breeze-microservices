<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class GetCommentLikeByCommentIdController extends Controller
{
    public function __invoke(Comment $comment)
    {
        return $comment->commentLikes()->paginate(10);
    }
}
