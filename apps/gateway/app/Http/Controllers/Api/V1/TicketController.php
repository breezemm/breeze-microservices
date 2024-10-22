<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        return response()->json([
            'data' => Order::where('ticket_id', $ticket->id)
                ->with('ticket.ticketType')
                ->with('event.user.media')
                ->with('user')
                ->first() ?? [
                    'ticket' => $ticket
                        ->with([
                            'phase.event.media',
                            'ticketType.phase.event.user.media',
                        ])
                        ->first(),
                ],
        ]);

    }

    public function update(Request $request, Ticket $ticket)
    {
        try {
            DB::beginTransaction();
            $validation = $request->validate([
                'remark' => 'nullable|string',
                'is_available' => 'nullable|boolean',
            ]);
            $ticket->update([
                ...$validation,
                'status' => $request->is_available ? TicketStatusEnum::AVAILABLE : TicketStatusEnum::UNAVAILABLE,
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Ticket updated successfully',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => 'Ticket update failed',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
