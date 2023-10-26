<?php

namespace App\Domains\Events\Events;

use App\Domains\Events\Exceptions\EventCreatedFailed;
use App\Models\Event;

class EventCreated
{
    /**
     * @throws EventCreatedFailed
     */
    public function __construct(array $data)
    {
        try {
            $event = Event::create($data);
            $event->addMediaFromBase64($data['image'])
                ->toMediaCollection('event-images');
        } catch (\Exception $e) {
            throw new EventCreatedFailed($e->getMessage());
        }
    }
}
