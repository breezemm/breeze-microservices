<?php

use App\Http\Controllers\ScanToPayController;
use App\Http\Controllers\TransferBalanceController;
use App\Http\Controllers\WalletController\GetWalletByUserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    try {
        return response()->json([
            'message' => 'Welcome to the Wallet API'
        ]);
    } catch (\Exception $exception) {
        return abort(500, $exception->getMessage());
    }
});


Route::prefix('wallets')->group(function () {
    Route::post('/', GetWalletByUserController::class);

    // peer to peer transaction
    Route::post('/transfer', TransferBalanceController::class);
    Route::post('/scan-to-pay', ScanToPayController::class);

});
