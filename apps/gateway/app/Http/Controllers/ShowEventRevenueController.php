<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowEventRevenueController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $orders = Order::where('event_id', $event->id)
            ->with('ticket.ticketType')
            ->get()
            ->sum(function ($order) {
                return $order->ticket->ticketType->price;
            });

        return response()->json([
            'data' => [
                'revenue' => $orders,
            ],
        ]);
    }
}
