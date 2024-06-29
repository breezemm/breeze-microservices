<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use MyanmarCyberYouths\Breeze\Breeze;

class GetAllRepliesByParentPostId extends Controller
{
    public function __construct(
        public readonly Breeze $breeze,
    )
    {
    }

    public function __invoke(Comment $comment, Request $request)
    {
        $comment = $comment->whereNotNull('parent_id')
            ->with('media')
            ->withCount('likes')
            ->withCount('replies')
            ->orderByDesc('created_at')
            ->paginate(5);

        $userIds = $comment->pluck('user_id')->toArray();
        $users = $this->breeze->auth()->users($userIds)->collect()->keyBy('id');

        $comments = $comment->collect()->map(fn(Comment $comment) => $comment->setAttribute('user', $users->get($comment->user_id)));


        return response()->json(['data' => $comments]);
    }
}
