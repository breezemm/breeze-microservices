<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data;

class CreatePostController extends Controller
{
    public function __invoke(CreatePostRequest $request)
    {
        DB::beginTransaction();

        try {
            $post = $this->createPost($request);
            $this->uploadImage($post, $request);
            $phases = $this->createPhases($post, $request);
            $this->createTickets($phases, $request);

            // TODO: Emit a post created event to the activity service
            // $this->emitPostCreatedEvent($post);

            DB::commit();

            return $post;
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, 'Event creation failed');
        }
    }

    private function createPost(CreatePostRequest $request)
    {
        return Post::create($request->validated() + ['user_id' => auth()->id()]);
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws InvalidBase64Data
     */
    private function uploadImage(Post $post, CreatePostRequest $request)
    {
        $post->addMediaFromBase64($request->validated('image'))->toMediaCollection('event-images');
    }

    private function createPhases(Post $post, CreatePostRequest $request)
    {
        return $post->phases()->createMany($request->validated('phases'));
    }

    private function createTickets($phases, CreatePostRequest $request)
    {
        foreach ($phases as $index => $phase) {
            $ticketTypes = $request->validated('phases')[$index]['ticket_types'];

            $phase->ticketTypes()->createMany($ticketTypes)->each(function (TicketType $ticketType) {
                $this->createTicketsForTicketType($ticketType);
            });
        }
    }

    private function createTicketsForTicketType(TicketType $ticketType)
    {
        $totalSeats = $ticketType->total_seats;
        $hasSeatingPlan = $ticketType->is_has_seating_plan;

        if (!$hasSeatingPlan && $totalSeats <= 0) {
            $this->createNonSeatingPlanTicket($ticketType);
        } else {
            $this->createSeatingPlanTickets($ticketType, $totalSeats);
        }
    }

    private function createNonSeatingPlanTicket(TicketType $ticketType)
    {
        Ticket::create([
            'user_id' => auth()->id(),
            'phase_id' => $ticketType->phase_id,
            'ticket_type_id' => $ticketType->id,
            'seat_number' => null,
        ]);
    }

    private function createSeatingPlanTickets(TicketType $ticketType, $totalSeats)
    {

        foreach (range(1, $totalSeats) as $seatNumber) {
            Ticket::create([
                'user_id' => auth()->id(),
                'phase_id' => $ticketType->phase_id,
                'ticket_type_id' => $ticketType->id,
                'seat_number' => $seatNumber,
            ]);
        }
    }

    // private function emitPostCreatedEvent(Post $post)
    // {
    //     auth()->user()->activities()->create([
    //         'event_id' => $post->id,
    //         'action_type' => UserActionTypeEnum::Create,
    //     ]);
    // }
}
