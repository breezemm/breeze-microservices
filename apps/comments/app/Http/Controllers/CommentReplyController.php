<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentReplyRequest;
use App\Models\Comment;

class CommentReplyController extends Controller
{
    public function __invoke(
        Comment                   $comment,
        CreateCommentReplyRequest $createCommentReplyRequest,
    )
    {
        $comment->create([
            ...$createCommentReplyRequest->validated(),
            'user_id' => auth()->id(),
        ]);
    }
}
