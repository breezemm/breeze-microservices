<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Models\NotificationType;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function create(Request $request)
    {
        $validation = $request->validate([
            'notification_id' => 'required|string|unique:notifications,id',
        ]);

        $notification = NotificationType::create([
            'notification_id' => $validation['notification_id'],
            'settings' => [
                'channels' => [
                    'email' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ],
                    'sms' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ],
                    'push' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ],
                    'web_push' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ]
                ]
            ]
        ]);
    }

    public function send(NotificationSendRequest $request)
    {
        // notification_id
        // user_id
        // message -> have type of channel and message

        $payload = [
            'notification_id' => 'notification_id',
            'user' => [
                'user_id' => 'user_id', // must
                'email' => 'email',
                'phone_number' => 'phone',
            ],
            'message' => [
                'notification' => [
                    ''
                ]
            ]
        ];
        return $payload;
    }
}
