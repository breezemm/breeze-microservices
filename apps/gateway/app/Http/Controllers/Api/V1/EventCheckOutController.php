<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CheckOutOrderAction;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckOutReqeust;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventCheckOutController extends Controller
{

    public function __construct(
        public readonly CheckOutOrderAction $checkOutOrder
    )
    {
    }

    public function __invoke(CreateCheckOutReqeust $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::findOrFail($request->validated('ticket_id'));

            $isAlreadyPurchased = auth()->user()->orders()->where('ticket_id', $request->validated('ticket_id'))->exists();
            if ($isAlreadyPurchased) {
                return response()->json([
                    'message' => 'You already purchased this ticket',
                ], 400);
            }

            if ($ticket->status === TicketStatus::SOLD) {
                return response()->json([
                    'message' => 'Ticket already sold',
                ], 400);
            }

            // if ticket has seating number
            if ($ticket->seat_number) {
                $ticket->update([
                    'status' => TicketStatus::SOLD,
                ]);

                $event = Event::findOrFail($request->validated('event_id'));
                $this->checkOutOrder->handle($event, $ticket);
            }


//            free ticket or ticket without seating number
            $order = auth()->user()
                ->orders()
                ->create([
                    'event_id' => $request->validated('event_id'),
                    'ticket_id' => $request->validated('ticket_id'),
                    'qr_code' => Str::uuid(),
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Ticket purchased successfully',
                'data' => [
                    'order' => $order,
                ],
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            info($th->getMessage());
            return response()->json([
                'message' => 'Something went wrong, please try again later',
            ], 500);
        }
    }
}
