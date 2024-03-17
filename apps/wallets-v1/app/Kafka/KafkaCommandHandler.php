<?php

namespace App\Kafka;

use App\Actions\TransferMoneyAction;
use App\Jobs\WalletCreated;
use App\Services\TransactionService;
use App\Services\WalletService;
use App\Support\Payload;
use Illuminate\Support\Facades\Log;

class KafkaCommandHandler
{
    /**
     * @throws \Exception
     */
    public function handle(Payload $payload): void
    {
        info('Kafka Message: ' . print_r($payload, true));

        $transferMoneyAction = new TransferMoneyAction(app(WalletService::class), app(TransactionService::class));

        match ($payload->pattern) {
            'wallets.created' => WalletCreated::dispatch($payload->data),
            'wallets.transfer' => $transferMoneyAction->execute($payload->data),
            default => Log::error('Kafka Command not found' . $payload->pattern),
        };
    }
}
