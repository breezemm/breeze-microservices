<?php

use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\CreateCommentController;
use App\Http\Controllers\GetCommentByPostId;
use App\Http\Controllers\GetCommentLikeByCommentIdController;
use App\Http\Controllers\LikeCommentController;
use App\Http\Controllers\UnLikeCommentController;
use Illuminate\Support\Facades\Route;


Route::post('/comments', CreateCommentController::class);
Route::post('/comments/{comment}/reply', CommentReplyController::class);

Route::get('/posts/{postId}/comments', GetCommentByPostId::class);

Route::post('/comments/{comment}/like', LikeCommentController::class);
Route::delete('/comments/{comment}/unlike', UnLikeCommentController::class);

Route::get('/comments/{comment}/likers', GetCommentLikeByCommentIdController::class);
