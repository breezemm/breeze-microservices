<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Domains\Events\Events\EventDestroyed;
use App\Domains\Events\Exceptions\EventDestroyFailed;
use App\Http\Controllers\Controller;
use App\Models\Event;

class EventDestroyController extends Controller
{
    public function __invoke(Event $event)
    {
        try {
            dispatch(new EventDestroyed($event));

            return response()->noContent();
        } catch (EventDestroyFailed $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
