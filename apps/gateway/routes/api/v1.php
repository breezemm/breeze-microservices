<?php

use App\Http\Controllers\Api\V1\AcceptGuestInvitationController;
use App\Http\Controllers\Api\V1\EventSeatingPlanController;
use App\Http\Controllers\Api\V1\FriendSuggestionController;
use App\Http\Controllers\Api\V1\GuestInvitationController;
use App\Http\Controllers\Api\V1\GuestListController;
use App\Http\Controllers\Api\V1\PostByUserInterestsController;
use App\Http\Controllers\Api\V1\Posts\PostCreated\LaunchedEventController;
use App\Http\Controllers\Api\V1\Posts\PostSaved\PostSaveController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\ShowEventRevenueController;
use App\Http\Controllers\Api\V1\Suggestions\SuggestionController;
use App\Http\Controllers\Api\V1\Timeline\PrivateTimelineController;
use App\Http\Controllers\Api\V1\Timeline\ProfileTimeline;
use App\Http\Controllers\Api\V1\Timeline\PublicTimelineController;
use App\Http\Controllers\Api\V1\UserEventCheckInController;
use Illuminate\Support\Facades\Route;

Route::get('/public/timeline', PublicTimelineController::class);

// Following and Followers services
Route::middleware('auth:api')->prefix('/users')
    ->group(function () {
        Route::get('/{user:username}/activities', ProfileTimeline::class);
    });

// General Auth Routes and users services
Route::middleware('auth:api')
    ->group(function () {
        Route::get('/timeline', PrivateTimelineController::class);
        Route::get('/search', SearchController::class);
        Route::get('/suggested-friends', FriendSuggestionController::class);

        Route::post('/accept-invitation', AcceptGuestInvitationController::class);
    });

Route::middleware('auth:api')->prefix('events')
    ->group(function () {
        Route::get('/interests', PostByUserInterestsController::class);
        Route::get('/launched', LaunchedEventController::class);
        Route::get('/saved', [PostSaveController::class, 'index']);
        Route::get('/suggestions', SuggestionController::class);
    });


// Event Dashboard for the organizers
Route::middleware('auth:api')->prefix('event-dashboard')->group(function () {
    Route::get('{event}/revenue', ShowEventRevenueController::class);
    Route::get('/events/{event}/seating-plan', EventSeatingPlanController::class);
    Route::get('/events/{event}/guests', GuestListController::class);
    Route::post('/events/{event}/guests/{user}/invite', GuestInvitationController::class);

    Route::post('/scan-qr-code', [UserEventCheckInController::class, 'getTicketByQRCode']);
    Route::post('/check-in', [UserEventCheckInController::class, 'checkInEvent']);
});



// Admin Routes: Role and Permission Management
//Route::middleware(['auth:api', 'role:admin'])->name('admin.')->group(function () {
//    Route::apiResource('/roles', RoleController::class);
//    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
//    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
//
//    Route::resource('/permissions', PermissionController::class);
//    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
//    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
//
//    Route::get('/users', [UserController::class, 'index'])->name('users.index');
//    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
//    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
//    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
//    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
//    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
//});
