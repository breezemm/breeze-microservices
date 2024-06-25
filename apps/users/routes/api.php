<?php

use App\Http\Controllers\FollowUserController;
use App\Http\Controllers\GetAllFollowerController;
use App\Http\Controllers\GetAllFollowingController;
use App\Http\Controllers\UnfollowUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::post('/users/{id}/follow', FollowUserController::class);
    Route::post('/users/{id}/unfollow', UnfollowUserController::class);

    Route::post('/users/{id}/followers', GetAllFollowerController::class);
    Route::post('/users/{id}/following', GetAllFollowingController::class);
});
