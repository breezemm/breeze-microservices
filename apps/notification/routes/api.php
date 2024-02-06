<?php

use App\Http\Controllers\NotificationPreferencesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::put('/preferences', NotificationPreferencesController::class);
