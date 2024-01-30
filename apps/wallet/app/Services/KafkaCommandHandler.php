<?php

namespace App\Services;

use App\Jobs\WalletCreated;
use App\Support\Payload;
use Illuminate\Support\Facades\Log;

class KafkaCommandHandler
{
    public function handle(Payload $payload): void
    {
        info('KafkaCommandHandler: ' . $payload->pattern);

        match ($payload->pattern) {
            'wallets.created' => WalletCreated::dispatch($payload->data['user_id']),
            default => Log::error('Kafka Command not found' . $payload->pattern),
        };
    }
}
