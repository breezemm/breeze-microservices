<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\InterestController;
use App\Http\Controllers\Api\V1\Auth\ValidationController;
use App\Http\Controllers\Api\V1\Events\EventComments\CommentDisLikeController;
use App\Http\Controllers\Api\V1\Events\EventComments\CommentLikeController;
use App\Http\Controllers\Api\V1\Events\EventComments\EventCommentController;
use App\Http\Controllers\Api\V1\Events\EventLaunched\LaunchedEventController;
use App\Http\Controllers\Api\V1\Events\EventReactions\EventDisLikeController;
use App\Http\Controllers\Api\V1\Events\EventReactions\EventLikeController;
use App\Http\Controllers\Api\V1\Events\EventSaved\EventSaveController;
use App\Http\Controllers\Api\V1\Events\EventStoreController;
use App\Http\Controllers\Api\V1\Suggestions\SuggestionController;
use App\Http\Controllers\Api\V1\Timeline\ProfileTimeline;
use App\Http\Controllers\Api\V1\Timeline\TimelineController;
use App\Http\Controllers\Api\V1\UserFollowings\UserFollowController;
use App\Http\Controllers\Api\V1\UserFollowings\UserUnFollowController;
use App\Http\Requests\V1\Auth\VerifyController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/*
 * Auth Routes
 * @description: This route group contains all the routes related to authentication
 * */
Route::prefix('users')->group(function () {
    Route::post('/validate', [ValidationController::class, 'validateEmail']);
    Route::post('/resend', [ValidationController::class, 'resendVerificationCode']);
    Route::post('/verify', VerifyController::class);

    Route::post('/validate-profile-image', [ValidationController::class, 'validateProfileImage']);
    Route::get('/interests', InterestController::class);

    Route::post('/sign-up', [AuthController::class, 'register']);
    Route::post('/sign-in', [AuthController::class, 'login']);

    Route::middleware('auth:api')->post('/sign-out', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/me', [AuthController::class, 'getAuthUser']);
        Route::get('/me/activities', ProfileTimeline::class);

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

/*
 * Wallet Routes
 * @description: This route group contains all the routes related to wallet service
 * */
Route::any('/wallets/{any?}', function () {
    $throttleKey = Str::lower(request()->method()).'-'.Str::lower(request()->path()).'-'.request()->ip();
    $threadHold = 10;

    try {
        if (RateLimiter::tooManyAttempts($throttleKey, $threadHold)) {
            return response()->json([
                'meta' => [
                    'status' => 429,
                    'ok' => false,
                    'message' => 'Too many attempts, please try again later.',
                ],
                'data' => [],
            ], 429);
        }

        $response = Http::timeout(3)
            ->retry(3, 200)
            ->send(request()->method(), config('services.breeze.wallet').request()->getRequestUri(), [
                'query' => request()->query(),
                'headers' => request()->headers->all(),
                'body' => request()->getContent(),
            ]);

        return response($response->body(), $response->status(), $response->headers());
    } catch (Exception $exception) {

        RateLimiter::hit($throttleKey);

        return response()->json(
            json_decode($exception->response->body(), true),
            $exception->response->status()
        );
    }
})->where('any', '.*');
