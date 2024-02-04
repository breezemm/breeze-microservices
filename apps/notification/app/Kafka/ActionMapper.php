<?php

namespace App\Kafka;

use Illuminate\Support\Facades\Log;

class ActionMapper
{
    public function mapPatternToAction(string $pattern)
    {
        switch ($pattern) {
            case 'wallets.created':
                return new class {
                    public function handle($message): void
                    {
                        print_r($message->getBody());
                    }
                };
            case 'wallets.updated':
                return new class {
                    public function handle($message): void
                    {
                        print_r([
                            'message' => $message->getBody(),
                            'action' => 'wallets.updated',
                        ]);
                    }
                };
            case 'wallets.deleted':
                return new class {
                    public function handle($message): void
                    {
                        print_r([
                            'message' => $message->getBody(),
                            'action' => 'wallets.deleted',
                        ]);
                    }
                };

            case 'wallets.received':
                return new class {
                    public function handle($message): void
                    {
                        print_r([
                            'message' => $message->getBody(),
                            'action' => 'wallets.received',
                        ]);
                    }
                };
            default:
                Log::error('No action mapped for pattern: ' . $pattern);
                return null;
        }
    }
}
