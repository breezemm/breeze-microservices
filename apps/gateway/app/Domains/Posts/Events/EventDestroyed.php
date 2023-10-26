<?php

namespace App\Domains\Events\Events;

use App\Domains\Events\Exceptions\EventDestroyFailed;
use App\Models\Event;

class EventDestroyed
{
    /**
     * @throws EventDestroyFailed
     */
    public function __construct(Event $event)
    {
        try {
            $event->clearMediaCollection('event-images');
            $event->delete();
        } catch (\Exception $e) {
            throw new EventDestroyFailed();
        }
    }
}
