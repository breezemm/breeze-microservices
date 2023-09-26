<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;

class EventShowController extends Controller
{
    public function __invoke(Event $event)
    {
        return new EventResource($event);
    }
}
