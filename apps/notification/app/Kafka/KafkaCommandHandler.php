<?php

namespace App\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaCommandHandler
{
    public static function handle(KafkaConsumerMessage $message): void
    {
        $body = json_decode($message->getBody(), true);

        $pattern = $body['pattern'];
        (new ActionMapper)
            ->mapPatternToAction($pattern)
            ?->handle($body['data']);
    }
}
