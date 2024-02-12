<?php

namespace App\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaCommandHandler
{
    public static function handle(KafkaConsumerMessage $message): void
    {
        $body = json_decode($message->getBody(), true);
        $pattern = $body['pattern'];
        $action = (new ActionMapper())->mapPatternToAction($pattern);
        $action?->handle($body['data']);
    }
}
