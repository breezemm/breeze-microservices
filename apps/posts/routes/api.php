<?php

use App\Http\Controllers\CreatePostController;
use App\Http\Controllers\GetAllPostByUserIdController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostUnLikeController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\ShowPostController;
use App\Http\Controllers\UnSavePostController;
use Illuminate\Support\Facades\Route;


Route::post('/posts', CreatePostController::class)->middleware('auth:api');
Route::get('/posts/{post}', ShowPostController::class);
Route::get('/posts/launched', GetAllPostByUserIdController::class);

Route::get('/posts/saved', SavedPostController::class);
Route::post('/posts/{post}/save', SavePostController::class);
Route::delete('/posts/{post}/unsave', UnSavePostController::class);

Route::post('/posts/post}/like', PostLikeController::class);
Route::post('/posts/post}/unlike', PostUnLikeController::class);

