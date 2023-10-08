<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventStoreController extends Controller
{
    public function __invoke(EventRequest $request)
    {
        try {
            DB::beginTransaction();

            $event = Event::create($request->validated() + ['user_id' => auth()->id()]);
            $event->interests()->sync($request->validated('interests'));
            $phases = $event->phases()->createMany($request->validated('phases'));

            $event->addMediaFromBase64($request->validated('image'))
                ->toMediaCollection('event-images');

            // Create ticket base on the phases that we have been created before
            foreach ($phases as $index => $phase) {
                $phase->tickets()->createMany($request->phases[$index]['tickets']);
            }
            DB::commit();

            return response()->json(
                $event->with('phases.tickets')->findOrFail($event->id)
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'msg' => $exception->getMessage()
            ], 500);
        }
    }

}
