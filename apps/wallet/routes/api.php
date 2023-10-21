<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    try {
        throw new \Exception('Invalid request');
        return response()->json([
            'message' => 'Welcome to the Wallet API'
        ], 422);
    } catch (\Exception $exception) {
        return response()->json([
            'message' => 'Wallet service is not available at the moment.',
        ], 500);
    }
});
