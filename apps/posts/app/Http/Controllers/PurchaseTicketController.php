<?php

namespace App\Http\Controllers;

use App\Actions\CreatePurchase;
use App\DataTransferObjects\PurchaseTicketData;
use App\Models\Post;
use App\Models\Purchase;

class PurchaseTicketController extends Controller
{
    public function __invoke(PurchaseTicketData $purchaseTicketData, Post $post, CreatePurchase $createPurchase)
    {
        $isAlreadyPurchased = Purchase::where('user_id', auth()->id())->where('ticket_id', $purchaseTicketData->ticketId)->exists();


        abort_if($isAlreadyPurchased, 400, 'You already purchased for this ticket.');

        $purchase = $createPurchase->handle(
            post: $post,
            purchaseTicketData: $purchaseTicketData
        );

        return response()->json([
            'message' => 'Ticket purchased successfully',
            'data' => $purchase,
        ]);
    }
}
