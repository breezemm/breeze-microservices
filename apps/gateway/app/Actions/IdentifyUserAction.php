<?php

namespace App\Actions;

use App\Models\User;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class IdentifyUserAction
{
    /**
     * @throws \Exception
     */
    public function handle(User $user): void
    {
        $message = new Message(body: createKafkaPayload(
            topic: 'notifications',
            pattern: 'users.identify',
            data: [
                'user_id' => $user->id,
                'email' => $user->email,
            ],
        ));
        Kafka::publishOn('notifications')
            ->withMessage($message)
            ->send();
    }
}
