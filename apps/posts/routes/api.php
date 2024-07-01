<?php

use App\Http\Controllers\CreatePostController;
use App\Http\Controllers\GetAllGuestsController;
use App\Http\Controllers\GetAllPostByUserIdController;
use App\Http\Controllers\GetAllSeatingPlanController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostUnLikeController;
use App\Http\Controllers\PurchaseTicketController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\ShowPostController;
use App\Http\Controllers\ShowTicketById;
use App\Http\Controllers\UnSavePostController;
use App\Http\Controllers\UpdateTicket;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->group(function () {
    Route::get('/posts/launched', GetAllPostByUserIdController::class);
    Route::get('/posts/saved', SavedPostController::class);


    Route::post('/posts', CreatePostController::class);
    Route::get('/posts/{post}', ShowPostController::class);


    // TODO: implement guests
    // guest is purchased users so we don't need another table for guests
    Route::get('/posts/{post}/guests', GetAllGuestsController::class);


    Route::get('/posts/{post}/purchase', PurchaseTicketController::class);

    Route::get('/posts/{post}/seating-plan', GetAllSeatingPlanController::class);


    Route::get('tickets/{ticket}', ShowTicketById::class);
    Route::put('tickets/{ticket}', UpdateTicket::class);


    Route::post('/posts/{post}/save', SavePostController::class);
    Route::delete('/posts/{post}/unsave', UnSavePostController::class);

    Route::post('/posts/post}/like', PostLikeController::class);
    Route::post('/posts/post}/unlike', PostUnLikeController::class);


});
