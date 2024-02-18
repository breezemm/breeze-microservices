<?php

namespace App\Http\Controllers\Api\V1\Timeline;

use App\Http\Controllers\Controller;
use App\Traits\Pagination;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

class PrivateTimelineController extends Controller
{
    use Pagination;

    public function __invoke(Request $request)
    {
        $events = auth()
            ->user()
            ->followings()
            ->with(
                'followable',
                fn(Builder $builder) => $builder->with(
                    'activities',
                    fn(Builder $builder) => $builder->with('user')
                        ->with('event', fn(BelongsTo $query) => $query
                            ->with('user')
                            ->with('comments')
                            ->withCount('comments')
                            ->withCount('likers')
                            ->with('repost', function (HasOne $query) {
                                return $query->with(
                                    'event',
                                    fn(BelongsTo $query) => $query
                                        ->with('user')
                                        ->with('comments')
                                        ->withCount('comments')
                                        ->withCount('likers')
                                );
                            }))
                        ->latest('id')
                )
            )
            ->get();

        $mappedEvents = collect($events)
            ->map(fn($item) => $item['followable']['activities'])
            ->flatten(1)
            ->map(fn($item) => [
                'id' => $item['id'],
                'action_type' => $item['action_type'],
                'user' => $item['user'],
                'event' => auth()->user()->attachLikeStatus($item['event']),
            ])
            ->sortByDesc('id')
            ->values();

        return response()->json($this->paginate(collect($mappedEvents), 5));

    }
}
