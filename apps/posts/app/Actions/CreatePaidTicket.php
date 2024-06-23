<?php

namespace App\Actions;

use App\DataTransferObjects\PhaseData;
use App\DataTransferObjects\TicketTypeData;
use App\Models\Post;
use App\Models\TicketType;
use Spatie\LaravelData\DataCollection;

class CreatePaidTicket
{

    /**
     * @param TicketType $ticketType
     * @param int $totalSeats
     * @param Post $post
     * @param DataCollection<PhaseData> $phases
     * @return void
     */
    public function handle(TicketType $ticketType, int $totalSeats, Post $post, DataCollection $phases): void
    {
        foreach (range(1, $totalSeats) as $seatNo)
            $ticketType->tickets()->create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'seat_no' => $seatNo,
            ]);

        $phases?->toCollection()->each(
            fn(PhaseData $phaseData) => $ticketType->phases()->create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                ...$phaseData->toArray(),
            ]));
    }
}
