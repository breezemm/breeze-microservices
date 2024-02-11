<?php

use App\Http\Controllers\CreateNotificationTypeController;
use App\Http\Controllers\SendNotificationController;
use App\Http\Controllers\UpdateNotificationController;
use App\Http\Controllers\UserIdentifyController;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;


Route::post('/identify', [UserIdentifyController::class, 'create']);

Route::post('/notification-types/create', CreateNotificationTypeController::class);


Route::post('/update-notifications-type-settings', UpdateNotificationController::class);


Route::post('/send', SendNotificationController::class);


$token = "cvgRAZmRE1QKRuru--o4fS:APA91bGZYirlE6okLDKjOYe0-g7oGif_r665ClhnATFUau0iHrpf2_fYQTaZZcdpLEXoi5SCAYYs0j8GpSychTds9n1iMlLPKZpfbRrW-hXvevuXgq6imD4drI3g12xpauw11_66xmib";
Route::get('/push', function () use ($token) {
    try {
        $messaging = app()->make(Messaging::class);

        $message = CloudMessage::fromArray([
            'token' => $token,
            'notification' => [
                'title' => "Hello world",
                'body' => "Hello mother fuckers"
            ],
            'data' => [
                'key' => 'value',
                'key2' => 'value2'
            ]
        ]);
        $messaging->send($message);
        return "done";
    } catch (Exception $e) {
        return $e->getMessage();
    }
});
