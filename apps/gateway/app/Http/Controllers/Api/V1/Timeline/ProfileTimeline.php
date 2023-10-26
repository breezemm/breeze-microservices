<?php

namespace App\Http\Controllers\Api\V1\Timeline;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileTimeline extends Controller
{
    public function __invoke()
    {
        //        get the latest activity id for each event
        //        include action id 5 (event repost)
        $latestActivities = Activity::selectRaw('MAX(id) as id')
            ->where('user_id', auth()->id())
            ->whereIn('action_id', [5])
            ->orWhereNotIn('action_id', [5])
            ->groupBy('event_id')
            ->get();

        //         get the activities for the latest activity ids
        $activities = Activity::whereIn('id', $latestActivities->pluck('id'))
            ->with('user')
            ->with('action')
            ->with('event', function (BelongsTo $query) {
                return $query->with('repost', function (HasOne $query) {
                    return $query->with(
                        'event',
                        fn (BelongsTo $query) => $query->with('user')
                    );
                });
            })
            ->latest('id')
            ->get();

        return response()->json($activities);
        //        return UserActivityFeedResource::collection($activities);
    }
}
