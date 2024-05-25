<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\SendPushNotification;
use App\Enums\BuyerTypeEnum;
use App\Enums\GuestInvitationStatusEnum;
use App\Enums\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AcceptGuestInvitationRequest;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AcceptGuestInvitationController extends Controller
{
    public function __invoke(AcceptGuestInvitationRequest $request)
    {

        try {
            DB::beginTransaction();

            Order::where('ticket_id', $request->validated('ticket_id'))
                ->where('user_id', auth()->id())
                ->where('buyer_type', BuyerTypeEnum::GUEST)
                ->update([
                    'guest_invitation_status' => GuestInvitationStatusEnum::ACCEPTED,
                ]);

            $ticket = Ticket::findOrFail($request->validated('ticket_id'));

            $ticket->update([
                'status' => TicketStatusEnum::UNAVAILABLE,
            ]);

            $event = Event::findOrFail($request->validated('event_id'));

            if ($event->user->id === auth()->id()) {
                return response()->json([
                    'message' => 'You are the owner of this event',
                ], 400);
            }

            if ($ticket->status === TicketStatusEnum::UNAVAILABLE) {
                return response()->json([
                    'message' => 'Ticket is not available',
                ], 400);
            }

            DB::commit();

//            (new SendPushNotification())->handle([
//                'notification_id' => 'event_invitation_accepted',
//                'user' => [
//                    'user_id' => $event->user->id, // notify to the event organizer
//                ],
//                'channels' => [
//                    'push' => [
//                        'title' => 'Invitation Accepted',
//                        'body' => auth()->user()->name . ' accept your invitation.',
//                        'data' => [
//                            'type' => 'event_invitation_accepted',
//                            'user' => auth()->user()->load('media'),
//                            'content' => ' accept your invitation.',
//                        ],
//                    ],
//                ],
//            ]);

            return response()->json([
                'message' => 'Invitation accepted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::log('error', $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
            ], 400);
        }
    }
}
