<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\GetAllCommentsByPostIdData;
use App\Models\Comment;
use MyanmarCyberYouths\Breeze\Breeze;

class GetCommentByPostId extends Controller
{
    public function __construct(
        public readonly Breeze $breeze,
    )
    {
    }

    public function __invoke(GetAllCommentsByPostIdData $getAllCommentsByPostIdData)
    {
        $comments = Comment::with('media')
            ->where('post_id', $getAllCommentsByPostIdData->postId)
            ->withCount('replies')
            ->get()
            ->toTree('replies');


        $userIds = $comments->pluck('user_id')->toArray();
        $users = $this->breeze->auth()->users($userIds)->collect()->keyBy('id');

        $comments->map(function ($comment) use ($users) {
            $comment->user = $users->get($comment->user_id);
            $comment->replies->map(function ($reply) use ($users) {
                $reply->user = $users->get($reply->user_id);
                return $reply;
            });
            return $comment;
        });

        return response()->json([
            'data' => $comments,
        ]);
    }
}
