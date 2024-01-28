<?php

namespace App\Http\Controllers\Api\V1\Timeline;

use App\Enums\ActionType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileTimeline extends Controller
{
    public function __invoke(string $username)
    {

        $user = User::whereUsername($username)->firstOrFail();

        $latestActions = Activity::selectRaw('MAX(id) as id')
            ->where('user_id', $user->id)
            ->whereIn('action_type', [ActionType::Repost])
            ->orWhereNotIn('action_type', [ActionType::Repost])
            ->groupBy('event_id')
            ->get();

        $activities = Activity::whereIn('id', $latestActions->pluck('id'))
            ->with('user')
            ->with('event', function (BelongsTo $query) {
                return $query
                    ->withCount('likers')
                    ->with('comments')
                    ->withCount('comments')
                    ->with('repost', function (HasOne $query) {
                        return $query
                            ->with('comments', fn (HasMany $query) => $query->with('user'))
                            ->withCount('comments')
                            ->with(
                                'event',
                                fn (BelongsTo $query) => $query->with('user')
                            );
                    });
            })
            ->latest('id')
            ->get();

        return response()->json($activities);
    }
}
