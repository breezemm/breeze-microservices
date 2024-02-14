<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateNotificationRequest;
use App\Models\NotificationList;


class UpdateNotificationController extends Controller
{
    public function __invoke(UpdateNotificationRequest $request, int $notificationId)
    {

        try {
            $notificationId = $request->notificationId;

            $notification = NotificationList::where('id', $notificationId)->first();

            if ((int)$notification->user_id !== (int)$request->user_id) {
                return response()->json([
                    'message' => 'You are not authorized to update this notification'
                ], 403);
            }

            $notification->update([
                'is_read' => true
            ]);


            return response()->json([
                'message' => 'Notification has been updated'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Notification not found'
            ], 404);
        }
    }
}
