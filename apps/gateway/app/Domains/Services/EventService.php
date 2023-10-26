<?php

namespace App\Domains\Services;

use App\Domains\Events\Exceptions\EventCreatedFailed;
use App\Domains\Repositories\EventRepository;
use App\Http\Requests\V1\EventRequest;

class EventService
{
    public function __construct(
        private readonly EventRepository $eventRepository
    ) {
    }

    /**
     * @throws EventCreatedFailed
     */
    public function createEvent(EventRequest $request): void
    {
        $this->eventRepository->createEvent($request);
    }
}
