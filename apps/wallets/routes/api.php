<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/wallets', WalletController::class)->except('update');
Route::apiResource('/payments', PaymentController::class)->only('store');

Route::get('/wallets/users/{userId}', [WalletController::class, 'getWalletByUserId']);
