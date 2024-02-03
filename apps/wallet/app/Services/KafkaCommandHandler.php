<?php

namespace App\Services;

use App\Actions\TransferMoneyAction;
use App\Jobs\WalletCreated;
use App\Support\Payload;
use Illuminate\Support\Facades\Log;

class KafkaCommandHandler
{
    /**
     * @throws \Exception
     */
    public function handle(Payload $payload): void
    {
        info('KafkaCommandHandler: ' . print_r($payload, true));


        $walletService = app(WalletService::class);
        $transferMoneyAction = new TransferMoneyAction($walletService);

        match ($payload->pattern) {
            'wallets.created' => WalletCreated::dispatch($payload->data['user_id']),
            'wallets.transfer' => $transferMoneyAction->handle($payload->data['from_user'], $payload->data['to_user'], $payload->data['amount']),
            default => Log::error('Kafka Command not found' . $payload->pattern),
        };
    }
}
