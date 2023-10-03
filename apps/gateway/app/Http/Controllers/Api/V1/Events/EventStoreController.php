<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Domains\Events\Events\EventCreated;
use App\Domains\Events\Exceptions\EventCreatedFailed;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EventRequest;
use App\Models\Event;

class EventStoreController extends Controller
{
    public function __invoke(EventRequest $request)
    {

//        try {
//            $data = $request->validated();
//            $data['date'] = date('Y-m-d', strtotime($data['date']));
//            $data['time'] = date('H:i:s', strtotime($data['time']));
//            $data['user_id'] = auth()->user()->id;
//
//            event(new EventCreated($data));
//
//            return response()->json([
//                'msg' => 'Event created successfully'
//            ], 201);
//        } catch (EventCreatedFailed $e) {
//            return response()->json([
//                'msg' => $e->getMessage()
//            ], 500);
//        }
    }
}
