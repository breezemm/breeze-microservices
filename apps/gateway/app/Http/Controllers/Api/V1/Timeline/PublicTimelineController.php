<?php

namespace App\Http\Controllers\Api\V1\Timeline;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicTimelineController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->get('page', 1);
        $events = Event::with([
            'user',
            'phases.ticketTypes',
            'comments' => fn (HasMany $query) => $query->with('user'),
        ])
            ->withCount('comments')
            ->withCount('likers')
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate(5);

        return Cache::remember("events_page_$page", 3, fn () => EventResource::collection($events));

    }
}
