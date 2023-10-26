<?php

namespace App\Domains\Repositories;

use App\Domains\Events\Exceptions\EventCreatedFailed;
use App\Http\Requests\V1\EventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    /**
     * @throws EventCreatedFailed
     */
    public function createEvent(EventRequest $request): void
    {
        try {
            DB::beginTransaction();

            $event = Event::create($request->validated() + ['user_id' => auth()->id()]);
            $event->interests()->sync($request->validated('interests'));
            $phases = $event->phases()->createMany($request->validated('phases'));

            $event->addMediaFromBase64($request->validated('image'))
                ->toMediaCollection('event-images');

            // Create ticket base on the phases that we have been created before
            foreach ($phases as $index => $phase) {
                $phase->tickets()->createMany($request->validated('phases')[$index]['tickets']);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new EventCreatedFailed($exception->getMessage());
        }
    }

    public function getEventById(Event $event): Event
    {
        return $event->load(['interests', 'phases.tickets']);
    }

    public function deleteEventById(Event $event): void
    {
        $event->delete();
        $event->interests()->detach();
        $event->phases()->delete();
        $event->phases->tickets()->delete();
    }
}
