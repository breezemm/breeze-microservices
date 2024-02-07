<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;

class SendNotificationController extends Controller
{


    /**
     * @param NotificationSendRequest $request
     * @return void
     *
     */

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
        $notification = $data['notification_id'];
        $user = $data['user'];
        $channels = $data['channels'];

        // send notification to user
         $notification->send($user, $channels);
    }
}
