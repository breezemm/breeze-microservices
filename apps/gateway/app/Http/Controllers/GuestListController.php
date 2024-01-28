<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class GuestListController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $guests = Order::where('event_id', $event->id)
            ->with('user.media')
            ->get();


        return response()->json([
            'guests' => $guests,
        ]);
    }
}
