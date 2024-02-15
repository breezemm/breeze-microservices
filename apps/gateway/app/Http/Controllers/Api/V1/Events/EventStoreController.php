<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Domains\Events\Exceptions\EventCreatedFailed;
use App\Domains\Services\EventService;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EventRequest;
use Illuminate\Support\Facades\Log;

class EventStoreController extends Controller
{
    public function __construct(
        private readonly EventService $eventService
    )
    {
    }

    public function __invoke(EventRequest $request)
    {
        try {
            $this->eventService->createEvent($request);

            return response()->json([
                'message' => 'Event created successfully',
            ]);
        } catch (EventCreatedFailed $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            Log::log('error', $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}
