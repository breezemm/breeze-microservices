<?php

namespace App\Http\Controllers\Api\V1\Posts;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Mockery\Exception;

class PostDestroyController extends Controller
{
    public function __invoke(Event $event)
    {
        try {
            $event->delete();
            $event->clearMediaCollection('event-images');
            $event->interests()->detach();
            $event->phases()->delete();

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
