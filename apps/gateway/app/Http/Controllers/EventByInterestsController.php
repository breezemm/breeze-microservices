<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventByInterestsController extends Controller
{
    public function __invoke(Request $request)
    {
        $userCity = auth()->user()->address()->first()->city()->first()->name;

        $filter = $request->has('filter') ? Str::ucfirst(trim($request->filter)) : $userCity;

        $userInterests = auth()->user()->interests()->pluck('interests.id');
        $interests = Interest::all()->pluck('id')->filter(function ($id) use ($userInterests) {
            return !$userInterests->contains($id);
        })->toArray();

        $userInterestedEvents = Interest::with('events')
            ->whereIn('id', $userInterests)
            ->get()
            ->map(fn($interest) => [
                'name' => $interest->name,
                'events' => $interest->events
                    ->filter(fn($event) => $event->place === $filter)
                    ->sortByDesc('created_at')
                    ->values(),
            ]);

        $otherEvents = Interest::with('events')
            ->whereIn('id', $interests)
            ->get()
            ->map(fn($interest) => [
                'name' => $interest->name,
                'events' => $interest->events
                    ->filter(fn($event) => $event->place === $filter)
                    ->sortByDesc('created_at')
                    ->values()
            ]);

        return response()->json([
            'data' => [
                'user_interested_events' => $userInterestedEvents,
                'other_events' => $otherEvents,
            ]
        ]);
    }
}
