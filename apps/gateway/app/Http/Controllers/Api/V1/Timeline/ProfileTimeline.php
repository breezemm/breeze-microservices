<?php

namespace App\Http\Controllers\Api\V1\Timeline;

use App\Enums\UserActionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Traits\Pagination;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileTimeline extends Controller
{
    use Pagination;

    public function __invoke(string $username)
    {

        $user = User::whereUsername($username)->firstOrFail();

        $latestActions = Activity::selectRaw('MAX(id) as id')
            ->where('user_id', $user->id)
            ->whereIn('action_type', [UserActionTypeEnum::Repost])
            ->orWhereNotIn('action_type', [UserActionTypeEnum::Repost])
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
            ->get()
            ->map(fn ($item) => [
                'id' => $item['id'],
                'action_type' => $item['action_type'],
                'user' => $item['user'],
                'event' => auth()->user()->attachLikeStatus($item['event']),
            ]);

        return response()->json($this->paginate(collect($activities), 5));
    }
}
