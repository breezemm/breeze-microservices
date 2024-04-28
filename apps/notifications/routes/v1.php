<?php

use App\Http\Controllers\CreateNewUserController;
use App\Http\Controllers\CreateNotificationTypeController;
use App\Http\Controllers\NotificationListController;
use App\Http\Controllers\SendNotificationController;
use App\Http\Controllers\StoreTokenController;
use App\Http\Controllers\UpdateNotificationController;

Route::prefix('/notifications')->group(function () {

    Route::post('/', [NotificationListController::class, 'index']);
    Route::post('/{notificationId}/read', UpdateNotificationController::class);

    Route::post('/send', SendNotificationController::class);
    Route::put('/tokens', StoreTokenController::class);

    Route::post('/types', CreateNotificationTypeController::class);

    Route::post('/users/identify', CreateNewUserController::class);
});
