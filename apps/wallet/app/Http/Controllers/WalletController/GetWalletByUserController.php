<?php

namespace App\Http\Controllers\WalletController;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletByUserIdDTO;
use App\Models\User;

class GetWalletByUserController extends Controller
{
    public function __invoke(WalletByUserIdDTO $walletByUserIdDTO)
    {
        $user = User::where('user_id',$walletByUserIdDTO->getWalletByUserId())->first();
        $user->load('wallets');

        return response()->json([
            'meta' => [
                'status' => 200,
                'message' => 'Wallet retrieved successfully.',
            ],
            'data' => $user->wallets,
        ], 200);

    }
}
