<?php

namespace App\Http\Controllers\Api\V1\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EventRequest;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;

class PostStoreController extends Controller
{
    public function __construct(
        private readonly PostService $eventService
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
        } catch (\Exception $e) {
            Log::log('error', $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}
