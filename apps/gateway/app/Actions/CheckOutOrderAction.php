<?php

namespace App\Actions;

use App\Models\Event;
use App\Models\Ticket;
use App\Services\WalletService;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class CheckOutOrderAction
{
    public function __construct(
        public readonly WalletService $walletService
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(Event $event, Ticket $ticket): void
    {

        $fromUser = auth()->id();
        $toUser = $event->user->id;

        $ticketPrice = $ticket->ticketType->price;

        $message = new Message(body: createKafkaPayload(
            topic: 'wallets',
            pattern: 'wallets.transfer',
            data: [
                'from_user' => $fromUser,
                'to_user' => $toUser,
                'amount' => $ticketPrice,
            ],
        ));
        Kafka::publishOn('wallets')
            ->withMessage($message)
            ->send();
    }
}
