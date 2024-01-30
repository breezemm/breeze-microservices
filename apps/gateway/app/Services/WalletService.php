<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class WalletService
{
    public function getMyWallet()
    {
        $wallets = Http::wallet()
            ->post('/wallets', [
                'user_id' => auth()->id(),
            ])
            ->json('user.wallets');
        return $wallets[0];
    }
}
