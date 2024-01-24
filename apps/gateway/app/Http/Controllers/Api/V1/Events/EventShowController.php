<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class EventShowController extends Controller
{
    public function __invoke(Event $event)
    {
        return new EventResource($event->load([
            'user',
            'phases' => function (HasMany $query) {
                $query->with('tickets');
            },
        ]));

    }
}
