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
            'parent_id' => $comment->id,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Comment replied successfully',
        ]);
    }
}
