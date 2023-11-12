<?php

namespace App\Http\Controllers\WalletController;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletByUserIdDTO;
use App\Models\User;

class GetWalletByUserController extends Controller
{
    public function __invoke(WalletByUserIdDTO $walletByUserIdDTO)
    {
        try {
            $user = User::where('user_id', $walletByUserIdDTO->user_id)->first();
            $user?->load('wallets');

            return response()->json([
                'meta' => [
                    'status' => 200,
                    'message' => 'Wallet retrieved successfully.',
                ],
                'data' => $user->wallets,
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'meta' => [
                    'status' => 404,
                    'message' => 'Wallet with the given user id is not found.',
                ],
                'data' => [],
            ], 404);
        }


    }
}
