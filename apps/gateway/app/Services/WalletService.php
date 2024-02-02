<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use function Laravel\Prompts\error;

class WalletService
{
    public function getMyWallet(?User $user = null)
    {
        try {
            $response = Http::wallet()
                ->async()
                ->post('/wallets', [
                    'user_id' => $user->id ?? auth()->id(),
                ])
                ->then(fn ($response) => $response->json());
            $wallets = $response->wait();

            return $wallets['user']['wallets'][0];
        } catch (\Exception $exception) {
            error('[ERROR]'.$exception->getMessage());
            abort(500, 'Internal Server Error');
        }

    }
}
