<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/', function () {
    try {
//        throw new \Exception('Invalid request');
        return response()->json([
            'message' => 'Welcome to the Wallet API'
        ], 422);
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
