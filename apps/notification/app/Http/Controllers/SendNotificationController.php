<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Models\User;
use NotificationChannels\Fcm\FcmMessage;

class SendNotificationController extends Controller
{


//    [
//            'notification_id' => 'notification_id',
//            'user' => [
//                'user_id' => 'user_id', // receiver user id
//                'email' => 'email',
//                'phone_number' => 'phone',
//            ],
//            'channels' => [
//                'push' => [
//                    'title' => 'notification_title',
//                    'body' => 'notification_body',
//                    'data' => [
//                        'key' => 'value',
//                    ],
//                ],
//            ]
//        ];
    public function __invoke(NotificationSendRequest $request)
    {
        $data = $request->validated();

        // send notification to user
        $userId = $data['user']['user_id'];
        $user = User::where('user_id', $userId)->first();

        FcmMessage::create()
            ->token()
            ->name($data['channels']['push']['title'])
            ->topic('news');

    }
}
