<?php

namespace App\Http\Controllers\Api\V1\Events;


use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EventRequest;
use App\Http\Requests\V1\EventUpdateRequest;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['show']);
    }

    public function index()
    {
        return response()->json([
            'msg' => 'success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {

        $data = $request->validated();
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['time'] = date('H:i:s', strtotime($data['time']));
        $data['user_id'] = auth()->user()->id;

        $event = Event::create($data);
        $event->addMediaFromBase64($data['image'])
            ->toMediaCollection('event-images');

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return Cache::remember("event_$event->id", 60, fn() => new EventResource($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        $data = $request->validated();
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['time'] = date('H:i:s', strtotime($data['time']));

        $event->update($data);

        if (isset($data['image'])) {
            $event->clearMediaCollection('event-images');
            $event->addMediaFromBase64($data['image'])
                ->toMediaCollection('event-images');
        }

        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        Cache::delete("event_$event->id");
        return response()->noContent();
    }

}
