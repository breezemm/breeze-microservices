<?php

namespace App\Http\Controllers\Api\V1\Wallet;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\Request;

class GetMyWalletController extends Controller
{
    public function __construct(
        private WalletService $walletService
    ) {
    }

    public function __invoke(Request $request)
    {
        $wallet = $this->walletService->getMyWallet();

        return response()->json([
            'data' => [
                'wallet' => $wallet,
            ],
        ]);
    }
}
