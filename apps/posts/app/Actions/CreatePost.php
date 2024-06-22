<?php

namespace App\Actions;

use App\Data\PhaseData;
use App\Data\PostData;
use App\Data\TicketTypeData;
use App\Models\Post;

class CreatePost
{

    public function handle(PostData $postData): void
    {
        $post = Post::create([
            'user_id' => auth()->id(),
            ...$postData->toArray(),
        ]);


        $postData->ticketTypes->toCollection()->each(function (TicketTypeData $ticketTypeData) use ($post) {
            $ticketType = $post->ticketTypes()->create([
                'user_id' => auth()->id(),
                ...$ticketTypeData->toArray()
            ]);


            // if the ticket type has quantity then create tickets with seat no
            if ($ticketTypeData->quantity > 0) {
                foreach (range(1, $ticketTypeData->quantity) as $seatNo)
                    $ticketType->tickets()->create([
                        'user_id' => auth()->id(),
                        'post_id' => $post->id,
                        'seat_no' => $seatNo,
                    ]);
            }

            $ticketTypeData?->phases?->toCollection()->each(
                fn(PhaseData $phaseData) => $ticketType->phases()->create([
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                    ...$phaseData->toArray(),
                ]));
        });

    }
}
