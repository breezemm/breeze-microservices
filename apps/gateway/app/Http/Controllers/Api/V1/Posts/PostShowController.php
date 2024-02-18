<?php

namespace App\Http\Controllers\Api\V1\Posts;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostShowController extends Controller
{
    public function __invoke(Event $event)
    {
        return new EventResource($event->load([
            'user',
            'phases' => function (HasMany $query) {
                $query->with([
                    'ticketTypes.tickets',
                ]);
            },
        ]));

    }
}
