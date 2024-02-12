<?php

namespace App\Http\Controllers\Api\V1\Events\EventComments;

use App\Actions\SendPushNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Event;

class EventCommentController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Event $event, CreateCommentRequest $createCommentReqeust)
    {

        if (!$createCommentReqeust->parent_id) {
            (new SendPushNotification())->handle([
                'notification_id' => 'post_commented',
                'user' => [
                    'user_id' => $event->user->id,
                ],
                'channels' => [
                    'push' => [
                        'title' => 'Post Commented',
                        'body' => auth()->user()->name . ' commented on your post.',
                        'data' => [
                            'type' => 'post_commented',
                            'user' => auth()->user()->with('media')->get(),
                            'content' => 'commented on your post.',
                        ]
                    ]
                ]
            ]);
        } else {
            $parentComment = $event->comments()->find($createCommentReqeust->parent_id);
            (new SendPushNotification())->handle([
                'notification_id' => 'comment_replied',
                'user' => [
                    'user_id' => $parentComment->user->id,
                ],
                'channels' => [
                    'push' => [
                        'title' => 'Comment Replied',
                        'body' => auth()->user()->name . ' replies you.',
                        'data' => [
                            'type' => 'comment_replied',
                            'user' => auth()->user()->with('media')->get(),
                            'content' => 'replies you.',
                        ]
                    ]
                ]
            ]);
        }

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
