<?php

namespace App\Actions;

use App\DataTransferObjects\PostData;
use App\DataTransferObjects\TicketTypeData;
use App\Models\Post;

readonly class CreatePost
{
    public function __construct(
        public CreateFreeTicket $createFreeTicket,
        public CreatePaidTicket $createPaidTicket,
    )
    {
    }


    public function handle(PostData $postData): Post
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

            if ($ticketTypeData->isFreeTicket) {
                $this->createFreeTicket->handle(
                    ticketType: $ticketType,
                    post: $post
                );
            }

            if ($ticketTypeData->isPaidTicket) {
                $this->createPaidTicket->handle(
                    ticketType: $ticketType,
                    totalSeats: $ticketTypeData->quantity,
                    post: $post,
                    phases: $ticketTypeData->phases,
                );
            }
        });

        return $post;
    }
}
