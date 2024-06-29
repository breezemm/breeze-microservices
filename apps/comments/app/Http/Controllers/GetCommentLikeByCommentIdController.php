<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use MyanmarCyberYouths\Breeze\Breeze;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class GetCommentLikeByCommentIdController extends Controller
{
    public function __construct(
        public readonly Breeze $breeze,
    )
    {
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function __invoke(Comment $comment)
    {
        $likes = CommentLike::where('comment_id', $comment->id)->paginate();

        $userIds = $likes->pluck('user_id')->toArray();

        $users = $this->breeze->auth()->users($userIds)->collect()->keyBy('id');

        $likes->map(function (CommentLike $comment) use ($users) {
            $comment->setAttribute('user', $users->get($comment->user_id));
            return $comment;
        });


        return response()->json($likes);
    }
}
