<?php

namespace App\Actions;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class SendPushNotification
{
    /**
     * @throws \Exception
     */
    public function handle(array $data = []): void
    {
        $message = new Message(
            body: createKafkaPayload(
                topic: 'notifications',
                pattern: 'notifications.send',
                data: $data,
            ));

        Kafka::publishOn('notifications')
            ->withMessage($message)
            ->send();

    }
}
