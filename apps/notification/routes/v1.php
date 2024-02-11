<?php

use App\Http\Controllers\CreateNotificationTypeController;
use App\Http\Controllers\SendNotificationController;
use App\Http\Controllers\UpdateNotificationController;
use App\Http\Controllers\CreateNewUserController;


Route::post('/identify', CreateNewUserController::class);

Route::post('/notification-types/create', CreateNotificationTypeController::class);

Route::post('/update-notifications-type-settings', UpdateNotificationController::class);


Route::post('/send', SendNotificationController::class);
