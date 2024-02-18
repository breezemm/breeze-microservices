<?php

namespace App\Http\Controllers\Api\V1\Posts\PostSaved;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class PostSaveController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $user = auth()->user();

        $savedEvents = $user->events()->latest('created_at')->paginate(5);

        return Cache::remember("events_saved_page_$page", 5, fn () => EventResource::collection($savedEvents));
    }

    public function store(Event $event)
    {
        $user = auth()->user();

        if ($user->events()->where('event_id', $event->id)->exists()) {
            abort(Response::HTTP_BAD_REQUEST, 'Event is already saved');
        }

        $user->events()->attach($event);

        return response()->json([
            'message' => 'Event saved successfully',
            'data' => $event,
        ], Response::HTTP_CREATED);
    }

    public function destroy(Event $event)
    {
        $user = auth()->user();

        if (! $user->events()->where('event_id', $event->id)->exists()) {
            abort(Response::HTTP_BAD_REQUEST, 'Event is not saved');
        }

        $user->events()->detach($event);

        return response()->json([
            'message' => 'Event unsaved successfully',
            'data' => $event,
        ], Response::HTTP_OK);
    }
}
