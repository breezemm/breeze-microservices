<?php

namespace App\Services;

use App\Jobs\WalletCreated;
use App\Support\Payload;
use Illuminate\Support\Facades\Log;

class CommandHandler
{
    public function handle(Payload $payload): void
    {
        match ($payload->pattern['cmd']) {
            'wallet.created' => WalletCreated::dispatch($payload->data),
            default => Log::error('Command not found'),
        };
    }
}
