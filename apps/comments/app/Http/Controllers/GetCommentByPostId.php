<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class GetCommentByPostId extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $postId = $request->postId;

        return Comment::with('media')
            ->withCount('replies')
            ->get()
            ->toTree('replies');
    }
}
