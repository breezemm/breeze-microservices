<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateNotificationRequest;
use App\Models\NotificationList;


class UpdateNotificationController extends Controller
{
    public function __invoke(UpdateNotificationRequest $request, NotificationList $notification)
    {

        if ($notification->user_id !== $request->user_id) {
            return response()->json([
                'message' => 'You are not authorized to update this notification'
            ], 403);
        }

        $notification->markedAsRead();

        return response()->json([
            'message' => 'Notification has been updated'
        ]);
    }
}
