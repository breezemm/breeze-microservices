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

class CheckoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        \Log::info('CheckoutJob');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Kafka::publishOn('wallets')
                ->withDebugEnabled()
                ->withMessage(
                    new Message(
                        body: json_encode([
                            'user_id' => 1,
                            'amount' => 100,
                            'type' => 'debit',
                            'description' => 'Test debit',
                            'transaction_id' => '123456789',
                        ]),
                    )
                )
                ->send();
            \Log::info('Checked out successfully');

            $consumer = Kafka::createConsumer()
                ->subscribe('wallets')
                ->withHandler(function (KafkaConsumerMessage $message) {
                    event(new WalletReceived($message->getBody()));
                    \Log::info('Received message: ' . json_encode($message->getBody()));
                })->build();
            $consumer->consume();

        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
        }
    }
}
