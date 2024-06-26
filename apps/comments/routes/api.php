<?php

use App\Http\Controllers\CreateCommentReplyController;
use App\Http\Controllers\CreateCommentController;
use App\Http\Controllers\GetCommentByPostId;
use App\Http\Controllers\GetCommentLikeByCommentIdController;
use App\Http\Controllers\LikeCommentController;
use App\Http\Controllers\UnLikeCommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {

    Route::get('/comments', GetCommentByPostId::class);
    Route::post('/comments', CreateCommentController::class);
    Route::post('/comments/{comment}/reply', CreateCommentReplyController::class);

    // TODO: Add middleware to check if the user is the owner of the comment
    Route::post('/comments/{comment}/like', LikeCommentController::class);
    Route::delete('/comments/{comment}/unlike', UnLikeCommentController::class);

    Route::get('/comments/{comment}/likers', GetCommentLikeByCommentIdController::class);
});
