<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\EmailValidationController;
use App\Http\Controllers\Api\V1\Auth\InterestController;
use App\Http\Controllers\Api\V1\Events\Comments\CommentDisLikeController;
use App\Http\Controllers\Api\V1\Events\Comments\CommentLikeController;
use App\Http\Controllers\Api\V1\Events\Comments\EventCommentController;
use App\Http\Controllers\Api\V1\Events\EventReactions\EventDisLikeController;
use App\Http\Controllers\Api\V1\Events\EventReactions\EventLikeController;
use App\Http\Controllers\Api\V1\Events\EventStoreController;
use App\Http\Controllers\Api\V1\Events\Launched\LaunchedEventController;
use App\Http\Controllers\Api\V1\Events\Saved\EventSaveController;
use App\Http\Controllers\Api\V1\Suggestions\SuggestionController;
use App\Http\Controllers\Api\V1\Timeline\ProfileTimeline;
use App\Http\Controllers\Api\V1\Timeline\TimelineController;
use App\Http\Controllers\Api\V1\UserFollowings\UserFollowController;
use App\Http\Controllers\Api\V1\UserFollowings\UserUnFollowController;
use Illuminate\Support\Facades\Route;


Route::prefix('users')->group(function () {
    Route::post('/validate-email', [EmailValidationController::class, 'validateEmail']);
    Route::post('/validate-profile-image', [EmailValidationController::class, 'validateProfileImage']);
    Route::get('/interests', [InterestController::class, 'index']);

    Route::post('/sign-up', [AuthController::class, 'register']);
    Route::post('/sign-in', [AuthController::class, 'login']);
});


Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/me', [AuthController::class, 'getAuthUser']);
        Route::get('/me/activities', ProfileTimeline::class);

        Route::post('/sign-out', [AuthController::class, 'logout']);

        Route::post('/{user}/follow', UserFollowController::class);
        Route::post('/{user}/unfollow', UserUnFollowController::class);
    });


    Route::prefix('events')->group(function () {
        Route::post('/', EventStoreController::class);


        Route::get('/saved', [EventSaveController::class, 'index']);
        Route::post('/{event}/save', [EventSaveController::class, 'store']);
        Route::post('/{event}/un-save', [EventSaveController::class, 'destroy']);

        Route::get('/launched', LaunchedEventController::class);
        Route::get('/{event}/comments', EventCommentController::class);
        Route::post('/{event}/like', EventLikeController::class);
        Route::post('/{event}/dislike', EventDisLikeController::class);

        Route::post('/{event}/comments/{comment}/like', CommentLikeController::class);
        Route::post('/{event}/comments/{comment}/dislike', CommentDisLikeController::class);

        Route::get('/suggestions', SuggestionController::class);
    });

});


Route::middleware('auth:api')->group(function () {
    Route::get('/timeline', TimelineController::class);

});

