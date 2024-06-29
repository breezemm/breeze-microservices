<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Exception;

class UnLikeCommentController extends Controller
{
    public function __invoke(Comment $comment)
    {
        try {
            $isSaved = CommentLike::where('user_id', auth()->id())
                ->where('comment_id', $comment->id)
                ->exists();

            abort_unless($isSaved, 400, 'Post not saved');

            CommentLike::where('comment_id', $comment->id)
                ->where('user_id', auth()->id())
                ->delete();

            return response()->noContent();
        } catch (Exception) {
            return response()->json([
                'message' => 'Failed to like comment'
            ], 500);
        }
    }
}
