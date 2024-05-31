<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::post('/otp/verify', [OTPController::class, 'verify']);
Route::post('/otp/resend', [OTPController::class, 'resend']);

Route::get('/interests', InterestController::class);
Route::get('/cities', CityController::class);

Route::post('/validate', [ValidationController::class, 'validateEmail'])->middleware('throttle:5,1'); // validate email or phone number

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/me', [AuthController::class, 'getCurrentAuthUser'])->middleware('auth:api');

