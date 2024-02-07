<?php

use App\Http\Controllers\UserIdentifyController;

$user = [
    'id' => 1,
    'email' => 'spongebob@squarepants.com',
    'number' => '+15005550006',
    'pushTokens' => [
        [
            'type' => 'FCM',
            'token' => 'samplePushToken',
            'device' => [
                'app_id' => 'com.example.app',
                'ad_id' => '1234567890',
                'device_id' => '1234567890',
                'platform' => 'android',
                'manufacturer' => 'Samsung',
                'model' => 'SM-G930F'
            ]
        ]
    ],
    'webPushTokens' => [
        [
            'sub' => [
                'endpoint' => 'https://fcm.googleapis.com/fcm/send/fCs_4iba0Ao:APA91bGFdaU7I3****JMH_KeZwk1Xi',
                'keys' => [
                    'p256dh' => 'zP2xFu3hMc2vNH5E2nuKkyjpZydvCk9llRUY2kP4****9aSlKcoadSV2UbvMRQ',
                    'auth' => 'CXEFun************tYe8g'
                ]
            ]
        ]
    ]
];

Route::prefix('users')
    ->group(function () {
        Route::post('/identify', UserIdentifyController::class);
    });
