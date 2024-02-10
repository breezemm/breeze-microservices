<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Models\NotificationType;

class CreateNotificationTypeController extends Controller
{


    public function __invoke(CreateNotificationRequest $request)
    {
        $notificationId = $request->validated('notification_id');
        $userId = $request->validated('user_id');

        $isNotificationTypeExists = NotificationType::where('user_id', $userId)->where('notification_id', $notificationId)->exists();

        if ($isNotificationTypeExists) {
            return response()->json(['message' => 'Notification type already exists'], 400);
        }


        $notificationType = NotificationType::create([
            'user_id' => $userId,
            'notification_id' => $notificationId,
            'settings' => [
                'channels' => [
                    'email' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ],
                    'sms' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ],
                    'push' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ],
                    'web_push' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ]
                ]
            ]
        ]);

        return response()->json($notificationType, 201);
    }


}
