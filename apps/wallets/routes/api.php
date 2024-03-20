<?php

use App\Http\Controllers\QRCodeValidationController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Cknow\Money\Money;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/wallets', WalletController::class);

Route::post('/validate-qr-code', QRCodeValidationController::class);
