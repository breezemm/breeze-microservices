<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CreateCommentData;
use App\Models\Comment;

class CreateCommentController extends Controller
{
    public function __invoke(CreateCommentData $createCommentData)
    {
        $comment = Comment::create([
            ...$createCommentData->toArray(),
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Comment created successfully', 'data' => $comment]);
    }
}
