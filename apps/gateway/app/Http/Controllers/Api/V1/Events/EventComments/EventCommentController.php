<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Event;

class EventCommentController extends Controller
{
    public function __invoke(Event $event, CreateCommentRequest $createCommentReqeust)
    {

        $event->comments()->create([
            'comment' => $createCommentReqeust->comment,
            'user_id' => auth()->id(),
            'parent_id' => $createCommentReqeust->parent_id ?? null,
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
        ], 201);
    }
}
