<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Http\Resources\V1\UserResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $searchTerm = $request->input('q');
        $latestUsers = User::where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('username', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->latest()
            ->take(10)
            ->get();

        $events = Event::with('interests')->get();

        //         Get all the events that have the interest and it should be unique
        $interestEvents = $events->flatMap(function ($event) {
            return $event->interests;
        })
            ->unique('pivot.event_id')
            ->unique('pivot.interest_id')
            ->map(function ($interest) {
                return [
                    'id' => $interest->pivot->event_id,
                ];
            })
            ->pluck('id')
            ->values();
        $eventsByInterest = Event::whereIn('id', $interestEvents)
            ->with('phases.ticketTypes')
            ->latest('id')
            ->get();

        return response()->json([
            'data' => [
                'suggested_friends' => UserResource::collection($latestUsers),
                'events' => EventResource::collection($eventsByInterest),
            ],
        ]);
    }
}
