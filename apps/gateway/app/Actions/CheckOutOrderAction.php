<?php

namespace App\Actions;

use App\Jobs\SendUserJoinedPushNotificationJob;
use App\Models\Event;
use App\Models\Ticket;
use Exception;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;


readonly class CheckOutOrderAction
{
    /**
     * @throws Exception
     */
    public function handle(Event $event, Ticket $ticket): void
    {

        $buyerUserId = auth()->id();
        $sellerUserId = $event->user->id;

        $ticketPrice = $ticket->ticketType->price;

        $message = new Message(body: createKafkaPayload(
            topic: 'wallets',
            pattern: 'wallets.transfer',
            data: [
                'sender_user_id' => $buyerUserId,
                'receiver_user_id' => $sellerUserId,
                'amount' => $ticketPrice,
            ],
        ));

        Kafka::publishOn('wallets')
            ->withMessage($message)
            ->send();


        // send push notification to the ticket seller after the buyer has bought the ticket
        (new SendPushNotification())->handle([
            'notification_id' => 'ticket_sold',
            'user' => [
                'user_id' => $sellerUserId,
            ],
            'channels' => [
                'push' => [
                    'title' => 'Ticket Sold',
                    'body' => auth()->user()->name . ' bought ' . $event->name . ' event.',
                    'data' => [
                        'type' => 'ticket_sold',
                        'user' => auth()->user()->load('media'),
                        'content' => 'joins',
                        'event' => $event,
                    ]
                ]
            ],
        ]);

        // Send push notification to all the users who joined early to the event
        $orders = $event->orders()
            ->whereNot('user_id', $buyerUserId)
            ->lazy(200);
        $orders->each(fn($order) => SendUserJoinedPushNotificationJob::dispatch($order));

    }
}
