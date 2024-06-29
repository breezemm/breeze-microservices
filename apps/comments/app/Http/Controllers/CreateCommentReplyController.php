<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CreateReplyData;
use App\Models\Comment;

class CreateCommentReplyController extends Controller
{
    public function __invoke(CreateReplyData $createReplyData, Comment $comment)
    {
        Comment::create([
            ...$createReplyData->toArray(),
            'post_id' => $comment->post_id,
            'parent_id' => $comment->id,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Replied successfully',
        ]);
    }
}
