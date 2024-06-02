<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\IntrospectionController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\ResendOneTimePasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::middleware("scopes:hey,hi")->get('/some', function () {

});

Route::post('oauth/introspect', IntrospectionController::class)->name('oauth.introspect');

Route::prefix('auth')->group(function () {
    Route::post('/email/verify', EmailVerificationController::class);
    Route::post('/otp/resend', ResendOneTimePasswordController::class)->middleware(['throttle:otp']);

    Route::post('/forgot-password', ForgotPasswordController::class);
    Route::post('/reset-password', ResetPasswordController::class)->middleware('guest');

    Route::get('/interests', InterestController::class);
    Route::get('/cities', CityController::class);

    Route::post('/validate', [ValidationController::class, 'validateEmail']);

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('/me', [AuthController::class, 'getCurrentAuthUser'])->middleware('auth:api');

});
