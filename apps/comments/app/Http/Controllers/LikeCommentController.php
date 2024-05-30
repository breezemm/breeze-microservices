<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class LikeCommentController extends Controller
{
    public function __invoke(Comment $comment)
    {
        $comment->commentLikes()->create([
            'user_id' => 'user_id',
        ]);

        return 'success';
    }
}
