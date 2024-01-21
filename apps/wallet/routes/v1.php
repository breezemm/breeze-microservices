<?php

use App\Http\Controllers\WalletController\GetWalletByUserController;
use App\Http\Controllers\TransferBalanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    try {
        return response()->json([
            'message' => 'Welcome to the Wallet API'
        ]);
    } catch (\Exception $exception) {
        return response()->json([
            'meta' => [
                'status' => 500,
                'message' => 'Wallet service is not available at the moment.',
            ],
            'data' => [],
        ], 500);
    }
});


Route::prefix('wallets')->group(function () {
    Route::post('/', GetWalletByUserController::class);

    // peer to peer transaction
    Route::post('/transfer', TransferBalanceController::class);

//     P2P QR code
//     validate qr code
//     ask money amount
//     confirm transaction


//     get ticket id from scanning qr code
//     validate ticket value
//    checkout ticket -> deduct ticket value from wallet balance ?
//    if success -> deduct ticket value from wallet balance
// transfer money to the ticket owner
//    if fail -> return error message

});

