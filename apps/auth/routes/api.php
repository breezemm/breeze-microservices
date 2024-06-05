<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\IntrospectionController;
use App\Http\Controllers\ResendOneTimePasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\EmailValidationController;
use Illuminate\Support\Facades\Route;


Route::post('oauth/introspect', IntrospectionController::class)->name('oauth.introspect');

Route::prefix('auth')->group(function () {
    Route::post('/email/validate', EmailValidationController::class)->middleware(['guest', 'throttle:5,1']);
    Route::post('/email/verify', EmailVerificationController::class)->middleware(['guest', 'throttle:5,1']); // 5 requests per minute
    Route::post('/otp/resend', ResendOneTimePasswordController::class)->middleware(['guest', 'throttle:5,1']);

    Route::post('/forgot-password', ForgotPasswordController::class)->middleware(['guest', 'throttle:5,1']);
    Route::post('/reset-password', ResetPasswordController::class)->middleware(['guest', 'throttle:5,1']);

    Route::get('/interests', InterestController::class);
    Route::get('/cities', CityController::class);


    Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('/me', [AuthController::class, 'getCurrentAuthUser'])->middleware('auth:api');

});

