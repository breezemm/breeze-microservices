<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return auth()->user()->orders()->with('ticket')->get();
    }

    public function show(Order $order)
    {
        return $order->with('ticket.ticketType.phase.event')->first();
    }
}
