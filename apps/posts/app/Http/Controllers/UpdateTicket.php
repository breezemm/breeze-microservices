<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\TicketData;
use App\Models\Ticket;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class UpdateTicket extends Controller
{
    /**
     * @throws CouldNotPerformTransition
     */
    public function __invoke(TicketData $ticketData, Ticket $ticket)
    {
        $ticket->update(['note' => $ticketData->note]);

        if ($ticket->available_state->canTransitionTo($ticketData->availableState)) {
            $ticket->available_state->transitionTo($ticketData->availableState);
        }

        return response()->json(['message' => 'Ticket updated']);
    }
}
