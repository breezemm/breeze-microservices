<?php

namespace App\Kafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaCommandHandler
{
    public static function handle(KafkaConsumerMessage $message): void
    {
        $body = $message->getBody();
        $pattern = $body['pattern'];
        $action = (new ActionMapper())->mapPatternToAction($pattern);
        print_r($message->getBody());
        $action?->handle($message);
    }
}
