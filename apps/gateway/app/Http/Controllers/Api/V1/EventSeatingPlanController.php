<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TicketStatusEnum;
use App\Http\Controllers\Controller;
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

                return $ticketType->tickets->where('status', TicketStatusEnum::AVAILABLE)->count();
            })->sum();
        })->sum();

        $soldSeatsCount = $event->phases->map(function ($phase) {
            return $phase->ticketTypes->map(function ($ticketType) {
                if (! $ticketType->is_has_seating_plan) {
                    return 0;
                }

                return $ticketType->tickets->where('status', TicketStatusEnum::SOLD)->count();
            })->sum();
        })->sum();

        $unAvailableSeatsCount = $event->phases->map(function ($phase) {
            return $phase->ticketTypes->map(function ($ticketType) {
                if (! $ticketType->is_has_seating_plan) {
                    return 0;
                }

                return $ticketType->tickets->where('status', TicketStatusEnum::UNAVAILABLE)->count();
            })->sum();
        })->sum();

        return response()->json([
            'available_count' => $availableSeatsCount,
            'sold_count' => $soldSeatsCount,
            'unavailable_count' => $unAvailableSeatsCount,
            'event' => new EventResource($event),
        ]);
    }
}
