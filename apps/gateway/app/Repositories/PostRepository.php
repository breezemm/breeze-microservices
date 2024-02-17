<?php

namespace App\Repositories;

use App\Enums\ActionType;
use App\Http\Requests\V1\EventRequest;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    /**
     * @throws \Exception
     */
    public function createEvent(EventRequest $request): void
    {

        try {
            DB::beginTransaction();

            $event = Event::create($request->validated() + ['user_id' => auth()->id()]);
            $event->interests()->sync($request->validated('interests'));
            $phases = $event->phases()->createMany($request->validated('phases'));

            $event->addMediaFromBase64($request->validated('image'))
                ->toMediaCollection('event-images');

            // Create ticket base on the phases that we have been created before
            foreach ($phases as $index => $phase) {
                $ticketTypes = $request->validated('phases')[$index]['ticket_types'];
                $phase->ticketTypes()->createMany($ticketTypes)
                    ->each(function ($ticketType) {
                        $totalSeats = $ticketType->total_seats;
                        $isHasSeatingPlan = $ticketType->is_has_seating_plan;

                        if ($isHasSeatingPlan && $totalSeats > 0) {
                            //                             if the ticket type has seating plan and total seats is greater than 0
                            //                            then we will create the ticket based on the total seats
                            foreach (range(1, $totalSeats) as $seatNumber) {
                                Ticket::create([
                                    'user_id' => auth()->id(),
                                    'phase_id' => $ticketType->phase_id,
                                    'ticket_type_id' => $ticketType->id,
                                    'seat_number' => $seatNumber,
                                ]);
                            }
                        } else {
                            //                            if the ticket type has no seating plan and total seats is greater than 0
                            //                            then we will create the ticket based on the total seats
                            //                            this can also apply to the ticket that is free
                            Ticket::create([
                                'user_id' => auth()->id(),
                                'phase_id' => $ticketType->phase_id,
                                'ticket_type_id' => $ticketType->id,
                                'seat_number' => null,
                            ]);
                        }

                    });
            }

            auth()->user()->activities()->create([
                'event_id' => $event->id,
                'action_type' => ActionType::Create,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, 'Event creation failed');
        }
    }
}
