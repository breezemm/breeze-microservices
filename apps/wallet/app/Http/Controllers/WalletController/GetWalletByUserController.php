<?php

namespace App\Http\Controllers\WalletController;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\WalletByUserIdDTO;
use App\Models\User;

class GetWalletByUserController extends Controller
{
    public function __invoke(WalletByUserIdDTO $walletByUserIdDTO)
    {
        try {
            $user = User::where('user_id', $walletByUserIdDTO->user_id)->first();
            $user?->load('wallets')
                ->get();

            return response()->json([
                'user' => $user,
            ], 200);

        } catch (\Exception $exception) {
            abort(404, 'Wallet not found');
        }
    }
}
