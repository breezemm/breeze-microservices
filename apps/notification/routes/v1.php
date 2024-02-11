<?php

use App\Http\Controllers\CreateNotificationTypeController;
use App\Http\Controllers\NotificationListController;
use App\Http\Controllers\SendNotificationController;
use App\Http\Controllers\UpdateNotificationController;
use App\Http\Controllers\CreateNewUserController;


Route::post('/users/identify', CreateNewUserController::class);

Route::prefix('/notifications')->group(function () {
    Route::get('/', [NotificationListController::class, 'index']);

    Route::post('/send', SendNotificationController::class);
    Route::post('/types/create', CreateNotificationTypeController::class);
});

Route::post('/update-notifications-type-settings', UpdateNotificationController::class);
