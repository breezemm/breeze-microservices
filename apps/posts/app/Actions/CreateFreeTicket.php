<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\TicketType;
use App\States\TicketUnlimited;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class CreateFreeTicket
{
    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(TicketType $ticketType, Post $post): void
    {
        $ticket = $ticketType->tickets()->create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);
        $ticket->available_state->transitionTo(TicketUnlimited::class);
    }
}
