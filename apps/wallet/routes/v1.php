<?php

use App\Http\Controllers\WalletController;
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
    Route::get('/', function () {
        return response()->json([
            'ok' => true,
            'message' => 'wallets'
        ]);
    });

    Route::get('/some', function () {
//        throw new \Exception('some');
        return response()->json([
            'ok' => true,
            'message' => 'some'
        ]);
    });

});
