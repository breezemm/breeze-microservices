<?php

use App\Http\Integrations\WalletServiceConnector;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Gateway service is healthy.',
    ]);
});

Route::get('test', function () {
    $wallet = new WalletServiceConnector();

    return response()->json([
        'status' => 200,
        'message' => 'Test route is working.',
    ]);
});
