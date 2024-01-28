<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventCheckOutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
            ]);

            if (auth()->user()->orders()->where('ticket_id', $request->ticket_id)->exists()) {
                return response()->json([
                    'message' => 'You already purchased this ticket',
                ], 400);
            }

            if (Ticket::find($request->ticket_id)->status === TicketStatus::SOLD) {
                return response()->json([
                    'message' => 'Ticket already sold',
                ], 400);
            }

            //             if ticket has no seating number, and it's free for all
            if (Ticket::find($request->ticket_id)->seat_number === null) {
                return auth()->user()
                    ->orders()
                    ->create([
                        'ticket_id' => $request->ticket_id,
                        'qr_code' => Str::uuid(),
                    ]);
            }

            // if ticket has seating number
            Ticket::find($request->ticket_id)->update([
                'status' => TicketStatus::SOLD,
            ]);

            return auth()->user()
                ->orders()
                ->create([
                    'ticket_id' => $request->ticket_id,
                    'qr_code' => Str::uuid(),
                ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ticket not found',
            ], 404);
        }
    }
}
