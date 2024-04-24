<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\Handler as HandlerContract;

class KafkaJob implements HandlerContract, ShouldQueue
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function __invoke(ConsumerMessage $message): void
    {
        info('Kafka message received');
    }
}
