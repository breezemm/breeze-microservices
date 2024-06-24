<?php

namespace App\Actions;

use App\DataTransferObjects\PurchaseTicketData;
use App\Models\Phase;
use App\Models\Post;
use App\Models\Purchase;
use Illuminate\Support\Facades\Crypt;

class CreatePurchase
{
    public function handle(Post $post, PurchaseTicketData $purchaseTicketData): Purchase
    {
        /** @var Phase $currentPhase */
//        $currentPhase = $post->ticketTypes()->with('phases')
//            ->where('id', $purchaseTicketData->ticketId)
//            ->get()
//            ->collect()
//            ->map(function ($ticketType) {
//                return $ticketType->phases->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
//            })->first();

        $qrCode = Crypt::encrypt([
            'user_id' => auth()->id(),
            'ticket_id' => $purchaseTicketData->ticketId,
            'post_id' => $post->id,
        ]);

        return Purchase::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'ticket_id' => $purchaseTicketData->ticketId,
            'qr_code' => $qrCode,
        ]);

    }
}
