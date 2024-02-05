<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CheckOutOrderAction;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckOutReqeust;
use App\Models\Event;
use App\Models\Ticket;
use App\Services\WalletService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventCheckOutController extends Controller
{
    public function __construct(
        public readonly WalletService $walletService
    )
    {
    }

    public function __invoke(CreateCheckOutReqeust $request)
    {
        try {
            DB::beginTransaction();

            $event = Event::findOrFail($request->validated('event_id'));
            $ticket = Ticket::findOrFail($request->validated('ticket_id'));

            $buyerUserId = auth()->id();
            $sellerUserId = $event->user->id;

            Cache::lock($buyerUserId . '_buying_ticket' . $ticket->id)->block(5, function () use ($buyerUserId, $ticket) {
                $ticket->lockForUpdate()->first();
            });

            if ($buyerUserId === $sellerUserId) {
                return response()->json([
                    'message' => 'You cannot purchase your own ticket',
                ], 400);
            }

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
            }

            // free ticket or ticket without seating number
            $order = auth()->user()
                ->orders()
                ->create([
                    'event_id' => $request->validated('event_id'),
                    'ticket_id' => $request->validated('ticket_id'),
                    'qr_code' => Str::uuid(),
                ]);

            $myBalance = $this->walletService->getMyWallet()['balance'];
            if ($myBalance < $ticket->ticketType->price) {
                return response()->json([
                    'message' => 'Insufficient balance',
                ], 400);
            }


            // We will use the CheckOutOrderAction to handle the checkout process, and then we will send
            // the event and ticket to the handle method of the CheckOutOrderAction
            // so that we can know the wallet and ticket price to be transferred
            $checkOutAction = new CheckOutOrderAction($this->walletService);
            $checkOutAction->handle($event, $ticket);

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
