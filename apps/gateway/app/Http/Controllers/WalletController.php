<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function index()
    {
        return Http::wallet()
            ->post('/wallets', [
                'user_id' => auth()->id(),
            ]);
    }
}
