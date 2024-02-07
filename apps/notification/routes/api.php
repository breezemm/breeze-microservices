<?php

use App\Http\Controllers\CreateNotificationTypeController;
use App\Http\Controllers\SendNotificationController;
use App\Http\Controllers\UpdateNotificationController;
use App\Http\Controllers\UserIdentifyController;


Route::post('/identify', [UserIdentifyController::class, 'create']);

Route::post('/notification-types/create', CreateNotificationTypeController::class);


Route::post('/update-notifications-type-settings', UpdateNotificationController::class);


Route::post('/send', SendNotificationController::class);


