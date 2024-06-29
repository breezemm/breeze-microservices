<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use MyanmarCyberYouths\Breeze\Breeze;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetCommentByPostId extends Controller
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
    public function __invoke(Request $request)
    {
        /** @var LengthAwarePaginator<Comment> $comments */
        $comments = QueryBuilder::for(Comment::class)
            ->allowedFilters([
                AllowedFilter::exact('post_id')
            ])
            ->whereNull('parent_id')
            ->withCount('likes')
            ->withCount('replies')
            ->orderByDesc('created_at')
            ->paginate()
            ->appends($request->query());

        $userIds = $comments->pluck('user_id')->toArray();
        $users = $this->breeze->auth()->users($userIds)->collect()->keyBy('id');

        $comments = $comments->collect()->map(fn(Comment $comment) => $comment->setAttribute('user', $users->get($comment->user_id)));

        return response()->json(['data' => $comments]);
    }
}
