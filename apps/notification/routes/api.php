<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserIdentifyController;


Route::post('/users/identify', [UserIdentifyController::class, 'create']);

Route::post('/send', [NotificationController::class, 'send']);
Route::post('/notifications', [NotificationController::class, 'create']);
