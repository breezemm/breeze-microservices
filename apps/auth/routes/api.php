<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityListController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;


Route::get('/interests', InterestController::class);
Route::get('/cities', CityListController::class);

Route::post('/validate', [ValidationController::class, 'validateEmail'])->middleware('throttle:5,1'); // validate email or phone number

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
});
