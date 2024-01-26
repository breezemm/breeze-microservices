<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentReqeust;
use App\Models\Event;

class EventCommentIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Event $event)
    {
        return $event->with('comments', fn($query) => $query->with('user'))
            ->withCount('comments')
            ->withCount('likers')
            ->get();

//        return response()->json([
//            'data' => [
//                'event' => $event->with('user')->first(),
//                'comments' => $event
//                    ->comments()
//                    ->withCount('comments')
//                    ->withCount('likers')
//                    ->with('user')
//                    ->get()
//                    ->toTree()
//            ]
//        ]);
    }
}
