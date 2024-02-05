<?php

namespace App\Kafka;

use Illuminate\Support\Facades\Log;

class ActionMapper
{
    public function mapPatternToAction(string $pattern)
    {
        switch ($pattern) {
            case 'wallets.done':
                return new class {
                    public function handle($message): void
                    {
                        echo 'wallet done';
                    }
                };
            case 'wallets.failed':
                return new class {
                    public function handle($message): void
                    {
                        echo 'wallet failed';
                    }
                };

            default:
                Log::error('No action mapped for pattern: ' . $pattern);
                return null;
        }
    }
}
