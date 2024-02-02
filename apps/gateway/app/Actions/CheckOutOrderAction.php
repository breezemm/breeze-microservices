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
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(Event $event, Ticket $ticket): void
    {
        $authUserWalletId = $this->walletService->getMyWallet()['wallet_id'];
        $eventOwnerWalletId = $this->walletService->getMyWallet($event->user)['wallet_id'];

        $ticketPrice = $ticket->ticketType->price;

        $message = new Message(body: createKafkaPayload(
            topic: 'wallets',
            pattern: 'wallets.transfer',
            data: [
                'amount' => $ticketPrice,
                'from_wallet_id' => $authUserWalletId,
                'to_wallet_id' => $eventOwnerWalletId,
            ],
        ));
        Kafka::publishOn('wallets')
            ->withMessage($message)
            ->send();
    }
}
