<?php

namespace App\Jobs;

use App\Events\WalletReceived;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Mockery\Exception;
use Opcodes\LogViewer\Logs\Log;

class CheckoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $data,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Received message: ' . $this->data['user_id']);
    }
}
