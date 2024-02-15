<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GetAllCommentLikers extends Controller
{
    public function __invoke(Request $request, Comment $comment, Event $event)
    {
        $page = $request->input('page', 1);

        return Cache::remember("event:{$event->id}:comment:{$comment->id}:page:{$page}", 60 * 60 * 24, function () use ($comment) {
            return $comment->likers()
                ->paginate(10);
        });
    }
}
