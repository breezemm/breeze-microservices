<?php

namespace App\Http\Controllers;

use App\Enums\BuyerType;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowEventRevenueController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $eventRevenue = Order::where('event_id', $event->id)
            ->with('ticket.ticketType')
            ->get()
            ->sum(function ($order) {
                if ($order->buyer_type === BuyerType::GUEST) {
                    return 0;
                }

                return $order->ticket->ticketType->price;
            });

        return response()->json([
            'data' => [
                'revenue' => $eventRevenue,
            ],
        ]);
    }
}
