<?php

namespace App\Services;

use App\Http\Requests\V1\EventRequest;
use App\Models\Event;
use App\Repositories\PostRepository;

class PostService
{
    public function __construct(
        private readonly PostRepository $eventRepository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function createEvent(EventRequest $request): Event
    {
        return $this->eventRepository->createEvent($request);
    }
}
