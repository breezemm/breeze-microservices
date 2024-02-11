<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Contract\Messaging;

class SubscribeFirebaseTopicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $notificationId,
        public readonly array  $firebaseTokens
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Messaging $messaging): void
    {
        $messaging->subscribeToTopic($this->notificationId, $this->firebaseTokens);

    }
}
