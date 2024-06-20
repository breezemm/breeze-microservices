<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Http\Requests\CreatePostRequest;
use App\Models\Phase;
use App\Models\Post;
use App\Models\Ticket;
use App\Models\TicketType;

class CreatePostController extends Controller
{
    public function __invoke(CreatePostRequest $request)
    {

        $post = Post::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'description' => $request->input('description'),
        ]);

        foreach ($request->ticket_types as $ticketTypeData) {
            $ticketType = TicketType::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'name' => $ticketTypeData['name'],
                'price' => $ticketTypeData['price'] ?? 0,
                'quantity' => $ticketTypeData['quantity'],
            ]);

            abort_unless($ticketTypeData['quantity'] >= 0 && $ticketTypeData['quantity'] <= 40, 422, 'Ticket quantity must be between 0 and 40');

            // create seating plan tickets
            if ($ticketTypeData['quantity'] > 0 && $ticketTypeData['quantity'] <= 40) {
                foreach (range(1, $ticketTypeData['quantity']) as $seat) {
                    Ticket::create([
                        'user_id' => auth()->id(),
                        'post_id' => $post->id,
                        'ticket_type_id' => $ticketType->id,
                        'seat_no' => $seat,
                        'state' => TicketStatus::InStock,
                    ]);
                }

            }

            // if the ticket has selling phases then create them
            if (isset($ticketTypeData['phases'])) {
                foreach ($ticketTypeData['phases'] as $phase) {
                    Phase::create([
                        'user_id' => auth()->id(),
                        'post_id' => $post->id,
                        'ticket_type_id' => $ticketType->id,
                        'name' => $phase['name'],
                        'start_date' => $phase['start_date'],
                        'end_date' => $phase['end_date'],
                        'price' => $phase['price'],
                    ]);
                }
            }
        }


    }
}
