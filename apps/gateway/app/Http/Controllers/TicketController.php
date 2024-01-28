<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;

class TicketController extends Controller
{

    public function show(Ticket $ticket)
    {
        return response()->json([
            'data' => Order::where('ticket_id', $ticket->id)
                ->with('ticket.ticketType')
                ->with('user')
                ->first() ?? $ticket->with('ticketType')->first(),
        ]);
    }


}
