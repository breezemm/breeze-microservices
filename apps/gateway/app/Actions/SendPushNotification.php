<?php

namespace App\Actions;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class SendPushNotification
{
    /**
     * @throws \Exception
     */
    public function handle(
        $recipientUserId,
        $title,
        $body,
        $image = null,
        $data = [],
    )
    {
        $data = [
            'notification_id' => 'new_follower',
            'user' => [
                'user_id' => $recipientUserId,
            ],
            'channels' => [
                'push' => [
                    'title' => $title,
                    'body' => $body,
                    'data' => $data,
                ],
            ],
        ];

        $message = new Message(body: createKafkaPayload(
            topic: 'notifications',
            pattern: 'notifications.send',
            data: [
                ...$data,
            ],
        ));

        Kafka::publishOn('notifications')
            ->withMessage($message)
            ->send();

    }
}
