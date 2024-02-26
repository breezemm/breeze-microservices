<?php

use App\Http\Controllers\UserLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return new \App\Http\Resources\UserResource($request->user());
});


Route::post('/auth/login', UserLoginController::class);
