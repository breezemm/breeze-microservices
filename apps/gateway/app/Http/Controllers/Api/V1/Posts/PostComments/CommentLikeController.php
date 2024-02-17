<?php

namespace App\Http\Controllers\Api\V1\Posts\PostComments;

use App\Actions\SendPushNotification;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class CommentLikeController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws \Exception
     */
    public function __invoke(Event $event, Comment $comment)
    {
        $lock = Cache::lock("comment:{$comment->id}:like", 5);
        try {
            $lock->block(5);

            auth()->user()->like($comment);

            (new SendPushNotification())->handle([
                'notification_id' => 'comment_liked',
                'user' => [
                    'user_id' => $comment->user->id,
                ],
                'channels' => [
                    'push' => [
                        'title' => 'Comment Liked',
                        'body' => auth()->user()->name . ' likes your comment.',
                        'data' => [
                            'type' => 'comment_liked',
                            'user' => auth()->user()->with('media')->get(),
                            'content' => 'likes your comment.',
                        ]
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            throw $e;
        } finally {
            optional($lock)->release();
            return response()->json([
                'message' => 'Comment liked successfully',
                'data' => $comment->likers()->count(),
            ]);
        }
    }
}
