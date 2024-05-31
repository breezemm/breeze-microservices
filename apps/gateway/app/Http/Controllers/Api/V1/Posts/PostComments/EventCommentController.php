<?php

namespace App\Http\Controllers\Api\V1\Posts\PostComments;

use App\Actions\SendPushNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateCommentRequest;
use App\Models\Event;

// TODO: refactor this class
class EventCommentController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Event $event, CreateCommentRequest $createCommentReqeust)
    {

        if (! $createCommentReqeust->parent_id) {

//            (new SendPushNotification())->handle([
//                'notification_id' => 'post_commented',
//                'user' => [
//                    'user_id' => $event->user->id,
//                ],
//                'channels' => [
//                    'push' => [
//                        'title' => 'Post Commented',
//                        'body' => auth()->user()->name . ' commented on your post.',
//                        'data' => [
//                            'type' => 'post_commented',
//                            'user' => auth()->user()->load('media'),
//                            'content' => 'commented on your post.',
//                        ],
//                    ],
//                ],
//            ]);

        } else {
            $parentComment = $event->comments()->find($createCommentReqeust->parent_id);

            if ($parentComment->user->id === auth()->id()) {
                return response()->json([
                    'message' => 'You can not reply to your own comment',
                ], 422);
            }

            (new SendPushNotification())->handle([
                'notification_id' => 'post_commented',
                'user' => [
                    'user_id' => $parentComment->user->id,
                ],
                'channels' => [
                    'push' => [
                        'title' => 'Post Replied',
                        'body' => auth()->user()->name . ' replied you',
                        'data' => [
                            'type' => 'post_commented',
                            'user' => auth()->user()->load('media'),
                            'content' => 'replies you.',
                        ],
                    ],
                ],
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
