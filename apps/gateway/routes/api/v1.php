<?php

use App\Http\Controllers\Api\V1\AcceptGuestInvitationController;
use App\Http\Controllers\Api\V1\AddFirebaseToken;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\InterestController;
use App\Http\Controllers\Api\V1\Auth\ValidationController;
use App\Http\Controllers\Api\V1\CityListController;
use App\Http\Controllers\Api\V1\EventSeatingPlanController;
use App\Http\Controllers\Api\V1\FollowerController;
use App\Http\Controllers\Api\V1\FollowingController;
use App\Http\Controllers\Api\V1\FriendSuggestionController;
use App\Http\Controllers\Api\V1\GetAllCommentLikers;
use App\Http\Controllers\Api\V1\GuestInvitationController;
use App\Http\Controllers\Api\V1\GuestListController;
use App\Http\Controllers\Api\V1\MarkedAsReadController;
use App\Http\Controllers\Api\V1\Notifications\GetAllNotificationController;
use App\Http\Controllers\Api\V1\OrderCheckOutController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PostByUserInterestsController;
use App\Http\Controllers\Api\V1\Posts\PostComments\CommentDisLikeController;
use App\Http\Controllers\Api\V1\Posts\PostComments\CommentLikeController;
use App\Http\Controllers\Api\V1\Posts\PostComments\EventCommentController;
use App\Http\Controllers\Api\V1\Posts\PostComments\EventCommentIndexController;
use App\Http\Controllers\Api\V1\Posts\PostCreated\LaunchedEventController;
use App\Http\Controllers\Api\V1\Posts\PostReactions\PostLikeController;
use App\Http\Controllers\Api\V1\Posts\PostReactions\PostUnLikeController;
use App\Http\Controllers\Api\V1\Posts\PostSaved\PostSaveController;
use App\Http\Controllers\Api\V1\Posts\PostShowController;
use App\Http\Controllers\Api\V1\Posts\PostStoreController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\ShowEventRevenueController;
use App\Http\Controllers\Api\V1\Suggestions\SuggestionController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\Timeline\PrivateTimelineController;
use App\Http\Controllers\Api\V1\Timeline\ProfileTimeline;
use App\Http\Controllers\Api\V1\Timeline\PublicTimelineController;
use App\Http\Controllers\Api\V1\UserEventCheckInController;
use App\Http\Controllers\Api\V1\UserFollowings\UserFollowController;
use App\Http\Controllers\Api\V1\UserFollowings\UserUnFollowController;
use App\Http\Controllers\Api\V1\Wallet\GetMyWalletController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Requests\V1\Auth\VerifyController;
use Illuminate\Support\Facades\Route;

Route::get('/public/timeline', PublicTimelineController::class);

Route::prefix('users')->group(function () {

    Route::post('/sign-up', [AuthController::class, 'register']);
    Route::post('/sign-in', [AuthController::class, 'login']);
    Route::middleware('auth:api')->post('/sign-out', [AuthController::class, 'logout']);

    Route::post('/validate', [ValidationController::class, 'validateEmail']);
    Route::post('/verify', VerifyController::class)->middleware('throttle:5,1');
    Route::post('/resend', [ValidationController::class, 'resendVerificationCode'])->middleware('throttle:5,1');

    Route::post('/validate-profile-image', [ValidationController::class, 'validateProfileImage']);
    Route::get('/interests', InterestController::class);
    Route::get('/cities', CityListController::class);
});


Route::middleware('auth:api')->prefix('/users')
    ->group(function () {
        Route::get('/me', [AuthController::class, 'getAuthUser']);

        Route::get('/{user:username}/activities', ProfileTimeline::class);

        Route::get('/{user:username}/profile', [AuthController::class, 'getProfile']);
        Route::get('/{user:username}/followers', FollowerController::class);
        Route::get('/{user:username}/followings', FollowingController::class);

        Route::post('/{user}/follow', UserFollowController::class);
        Route::post('/{user}/unfollow', UserUnFollowController::class);
    });

Route::middleware('auth:api')
    ->group(function () {
        Route::get('/timeline', PrivateTimelineController::class);
        Route::get('/search', SearchController::class);
        Route::get('/suggested-friends', FriendSuggestionController::class);

        Route::apiResource('/orders', OrderController::class)->only(['index', 'show']);


        Route::post('/checkout', OrderCheckOutController::class);
        Route::post('/accept-invitation', AcceptGuestInvitationController::class);
    });

Route::middleware('auth:api')->prefix('events')
    ->group(function () {
        Route::get('/interests', PostByUserInterestsController::class);
        Route::get('/launched', LaunchedEventController::class);
        Route::get('/saved', [PostSaveController::class, 'index']);
        Route::get('/suggestions', SuggestionController::class);

        Route::post('/', PostStoreController::class);
        Route::get('{event}', PostShowController::class);

        Route::post('/{event}/save', [PostSaveController::class, 'store']);
        Route::post('/{event}/un-save', [PostSaveController::class, 'destroy']);
        Route::post('/{event}/like', PostLikeController::class);
        Route::post('/{event}/dislike', PostUnLikeController::class);

        Route::get('/{event}/comments', EventCommentIndexController::class);
        Route::post('/{event}/comments', EventCommentController::class);
        Route::post('/{event}/comments/{comment}/like', CommentLikeController::class);
        Route::post('/{event}/comments/{comment}/dislike', CommentDisLikeController::class);

        Route::get('/{event}/comments/{comment}/likers', GetAllCommentLikers::class);
    });

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/tickets', TicketController::class)->only('show', 'update');
});

// Event Dashboard for the orginizers
Route::middleware('auth:api')->prefix('event-dashboard')->group(function () {
    Route::get('{event}/revenue', ShowEventRevenueController::class);
    Route::get('/events/{event}/seating-plan', EventSeatingPlanController::class);
    Route::get('/events/{event}/guests', GuestListController::class);
    Route::post('/events/{event}/guests/{user}/invite', GuestInvitationController::class);

    Route::post('/scan-qr-code', [UserEventCheckInController::class, 'getTicketByQRCode']);
    Route::post('/check-in', [UserEventCheckInController::class, 'checkInEvent']);
});

Route::middleware('auth:api')->prefix('wallets')->group(function () {
    Route::get('/me', GetMyWalletController::class);
});


Route::middleware('auth:api')->group(function () {
    Route::get('/notifications', GetAllNotificationController::class);
    Route::post('/notifications/tokens', AddFirebaseToken::class);
    Route::post('/notifications/{notificationId}/read', MarkedAsReadController::class);
});

// TODO: event_joined, wallet_cash_in, wallet_cash_out, wallet_transfer


// Admin Routes
Route::middleware(['auth:api', 'role:admin'])->name('admin.')->group(function () {
    Route::apiResource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');

    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');

});
