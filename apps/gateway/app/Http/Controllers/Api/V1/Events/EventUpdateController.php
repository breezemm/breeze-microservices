<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EventUpdateRequest;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;

class EventUpdateController extends Controller
{
    public function __invoke(EventUpdateRequest $request, Event $event)
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
}
