<?php

namespace App\Http\Controllers;

use App\Enums\BuyerType;
use App\Enums\GuestInvitationStatus;
use App\Enums\QRCodeStatus;
use App\Enums\TicketStatus;
use App\Http\Requests\InviteGuestRequest;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuestInvitationController extends Controller
{
    public function __invoke(InviteGuestRequest $request, Event $event, User $user)
    {
        $isGuestAlreadyInvited = Order::where('event_id', $event->id)
            ->where('ticket_id', $request->validated('ticket_id'))
            ->where('user_id', $user->id)
            ->where('buyer_type', BuyerType::GUEST)
            ->exists();

        if ($isGuestAlreadyInvited) {
            return response()->json([
                'message' => 'User already invited to this event!',
            ], 422);
        }

        try {
            DB::beginTransaction();
            $user->orders()->create([
                'buyer_type' => BuyerType::GUEST,
                'qr_code_status' => QRCodeStatus::PENDING,
                'qr_code' => Str::uuid(),
                'guest_invitation_status' => GuestInvitationStatus::PENDING,
                'ticket_id' => $request->validated('ticket_id'),
                'event_id' => $event->id,
            ]);

            // After guest invitation, ticket status should be unavailable
            // If the guest declines the invitation, the ticket status should be available again
            $ticket = Ticket::findOrFail($request->validated('ticket_id'));
            $hasSeatingPlan = $ticket->with('ticketType')
                ->first()
                ->ticketType
                ->is_has_seating_plan;

            if ($hasSeatingPlan) {
                $ticket->update([
                    'status' => TicketStatus::UNAVAILABLE,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Invitation sent successfully to '.$user->name.'!',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
