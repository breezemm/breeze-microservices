<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\EmailValidationController;
use App\Http\Controllers\Api\V1\Auth\InterestController;
use App\Http\Controllers\Api\V1\Events\EventComments\CommentDisLikeController;
use App\Http\Controllers\Api\V1\Events\EventComments\CommentLikeController;
use App\Http\Controllers\Api\V1\Events\EventComments\EventCommentController;
use App\Http\Controllers\Api\V1\Events\EventReactions\EventDisLikeController;
use App\Http\Controllers\Api\V1\Events\EventReactions\EventLikeController;
use App\Http\Controllers\Api\V1\Events\EventStoreController;
use App\Http\Controllers\Api\V1\Events\EventLaunched\LaunchedEventController;
use App\Http\Controllers\Api\V1\Events\EventSaved\EventSaveController;
use App\Http\Controllers\Api\V1\Suggestions\SuggestionController;
use App\Http\Controllers\Api\V1\Timeline\ProfileTimeline;
use App\Http\Controllers\Api\V1\Timeline\TimelineController;
use App\Http\Controllers\Api\V1\UserFollowings\UserFollowController;
use App\Http\Controllers\Api\V1\UserFollowings\UserUnFollowController;
use Illuminate\Support\Facades\Route;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;


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


Route::any('/wallets/{any?}', function () {
    try {
        $throttleKey = Str::lower(request()->method()) . '-' . Str::lower(request()->path()) . '-' . request()->ip();
        $threadHold = 10;

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, $threadHold)) {
            return response()->json([
                'message' => 'Too many attempts. Please try again later.',
            ], 429);
        }

        $client = new GuzzleHttp\Client([
            'base_uri' => config('services.breeze.wallet'),
            'timeout' => 30,
            'connect_timeout' => 60,
            'http_errors' => false,
        ]);

        $response = $client->request(
            method: request()->method(),
            options: [
                'query' => request()->query(),
                'headers' => request()->headers->all()
            ]);

        return response($response->getBody()->getContents(), $response->getStatusCode(), $response->getHeaders());
    } catch (\Exception $exception) {
        return response()->json([
            'meta' => [
                'status' => 500,
                'message' => 'Wallet service is not available at the moment.',
            ],
            'data' => [],
        ], 500);
    }
})->where('any', '.*');

Route::get('/checkout', function () {
    $amount = request('amount');


    Kafka::publishOn("checkout")
        ->withMessage(
            new Message(
                body: json_encode(

                    [
                        'data' => [
                            "name" => "John Doe",
                        ]
                    ]
                )
            )
        )
        ->send();


    return response()->json([
        'message' => 'test-topic published',
        'user' => collect([
            'name' => 'John Doe',
        ])->toJson(),
    ]);
});
