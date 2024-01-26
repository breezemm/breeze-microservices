<?php

namespace App\Http\Controllers\Api\V1\Timeline;

use App\Enums\ActionType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileTimeline extends Controller
{
    public function __invoke()
    {

        $latestActivities = Activity::selectRaw('MAX(id) as id')
            ->where('user_id', auth()->id())
            ->whereIn('action_type', [ActionType::Repost])
            ->orWhereNotIn('action_type', [ActionType::Repost])
            ->groupBy('event_id')
            ->get();
        return response()->json(
            Activity::whereIn('id', $latestActivities->pluck('id'))
                ->with('user')
                ->with('event', function (BelongsTo $query) {
                    return $query->with('comments')
                        ->with('repost', function (HasOne $query) {
                            return $query
                                ->with('comments', fn(HasMany $query) => $query->with('user'))
                                ->with(
                                    'event',
                                    fn(BelongsTo $query) => $query->with('user')
                                );
                        });
                })
                ->latest('id')
                ->get()
        );
    }
}
