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

        $senderUserId = auth()->id();
        $receiverUserId = $event->user->id;

        $ticketPrice = $ticket->ticketType->price;

        $message = new Message(body: createKafkaPayload(
            topic: 'wallets',
            pattern: 'wallets.transfer',
            data: [
                'sender_user_id' => $senderUserId,
                'receiver_user_id' => $receiverUserId,
                'amount' => $ticketPrice,
            ],
        ));
        Kafka::publishOn('wallets')
            ->withMessage($message)
            ->send();


        // send notification to the ticket seller that the ticket has been sold
        (new SendPushNotification())->handle([
            'notification_id' => 'ticket_sold',
            'user' => [
                'user_id' => $receiverUserId,
            ],
            'channels' => [
                'push' => [
                    'title' => 'Ticket Sold',
                    'body' => auth()->user()->name . ' joins ' . $event->name . ' event.',
                    'data' => [
                        'type' => 'ticket_sold',
                        'user' => auth()->user()->with('media')->get(),
                        'content' => 'joins',
                        'event' => $event,
                    ]
                ]
            ],
        ]);

        // Send notification to all the users who joined the event
        $event->orders()->chunk(100, function ($orders) {
            foreach ($orders as $order) {
                (new SendPushNotification())->handle([
                    'notification_id' => 'event_joined',
                    'user' => [
                        'user_id' => $order->user_id,
                    ],
                    'channels' => [
                        'push' => [
                            'title' => 'Join Event',
                            'body' => auth()->user()->name . ' joins ' . $order->event->name . ' event.',
                            'data' => [
                                'type' => 'event_joined',
                                'user' => auth()->user()->with('media')->get(),
                                'content' => 'joins',
                                'event' => $order->event,
                            ]
                        ]
                    ],
                ]);
            }
        });

    }
}
