<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentReqeust;
use App\Models\Event;

class EventCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Event $event, CreateCommentReqeust $createCommentReqeust)
    {
        if ($createCommentReqeust->parent_id) {
            $event->comments()->create([
                'comment' => $createCommentReqeust->comment,
                'user_id' => auth()->id(),
                'parent_id' => $createCommentReqeust->parent_id,
            ]);

            return response()->json([
                'message' => 'Reply created successfully',
            ], 201);
        }

        $event->comments()->create([
            'comment' => $createCommentReqeust->comment,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
        ], 201);
    }
}
