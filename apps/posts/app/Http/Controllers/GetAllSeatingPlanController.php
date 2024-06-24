<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Ticket;
use App\States\TicketInStock;
use App\States\TicketSold;
use App\States\TicketUnavailable;
use App\States\TicketUnlimited;
use Illuminate\Http\Request;

class GetAllSeatingPlanController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $post->load('ticketTypes.tickets');

        $ticketByPostIdQuery = Ticket::where('post_id', $post->id)->whereNotState('available_state', TicketUnlimited::class);

        $inStockCount = $ticketByPostIdQuery->clone()->whereState('available_state', TicketInStock::class)->count();

        $soldCount = $ticketByPostIdQuery->clone()->whereState('available_state', TicketSold::class)->count();

        $unavailableCount = $ticketByPostIdQuery->clone()->whereState('available_state', TicketUnavailable::class)->count();


        return response()->json([
            'data' => [
                'in_stock_count' => $inStockCount,
                'sold_count' => $soldCount,
                'unavailable_count' => $unavailableCount,
                'ticket_types' => $post->ticketTypes
            ],
        ]);
    }
}
