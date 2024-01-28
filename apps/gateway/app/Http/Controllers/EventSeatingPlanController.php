<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Http\Resources\V1\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventSeatingPlanController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $event = $event->with('phases.ticketTypes.tickets')
            ->find($event->id);
        $availableSeatsCount = $event->phases->map(function ($phase) {
            return $phase->ticketTypes->map(function ($ticketType) {
                if (! $ticketType->is_has_seating_plan) {
                    return 0;
                }

                return $ticketType->tickets->where('status', TicketStatus::AVAILABLE)->count();
            })->sum();
        })->sum();
        $unAvailableSeatsCount = $event->phases->map(function ($phase) {
            return $phase->ticketTypes->map(function ($ticketType) {
                if (! $ticketType->is_has_seating_plan) {
                    return 0;
                }

                return $ticketType->tickets->where('status', TicketStatus::UNAVAILABLE)->count();
            })->sum();
        })->sum();

        return response()->json([
            'available_count' => $availableSeatsCount,
            'unavailable_count' => $unAvailableSeatsCount,
            'event' => new EventResource($event),
        ]);
    }
}
