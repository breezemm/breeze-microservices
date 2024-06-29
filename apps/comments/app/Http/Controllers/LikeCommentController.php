<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;

class LikeCommentController extends Controller
{
    public function __invoke(Comment $comment)
    {
        $isLikedComment = CommentLike::where('comment_id', $comment->id)
            ->where('user_id', auth()->id())
            ->exists();

        abort_if($isLikedComment, "You already liked the comment");

        CommentLike::create([
            'user_id' => auth()->id(),
            'comment_id' => $comment->id,
        ]);

        return response()->json([
            'message' => 'Comment liked successfully',
        ]);
    }
}
