<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyWalletResource;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GetMyWalletController extends Controller
{
    public function __construct(
        private WalletService $walletService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $wallet = $this->walletService->getMyWallet();

        return response()->json([
            'data' => [
                'wallet' => $wallet,
            ]
        ]);
    }
}
