<?php

namespace App\Console\Commands;

use App\Events\WalletReceived;
use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Mockery\Exception;

class CheckoutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        try {
            Kafka::publishOn('wallets')
                ->withDebugEnabled()
                ->withMessage(
                    new Message(
                        body: json_encode([
                            'user_id' => 2,
                            'amount' => 100,
                            'type' => 'debit',
                            'description' => 'Test debit',
                            'transaction_id' => '123456789',
                        ]),
                    )
                )
                ->send();

            $this->info('Checked out successfully');
            \Log::info('Checked out successfully');

            $this->info('Waiting for messages...');
            $consumer = Kafka::createConsumer()
                ->subscribe('wallets')
                ->withHandler(function (KafkaConsumerMessage $message) {
                    event(new WalletReceived($message->getBody()));
                    \Log::info('Received message: ' . $message->getBody());
                    $this->info('Received message: ' . $message->getBody());
                })->build();
            $consumer->consume();
            $this->info('Consumed successfully');

        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
        }
    }
}
