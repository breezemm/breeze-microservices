<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\WalletData;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WalletController extends Controller
{

    public function __construct(
        public readonly WalletService $walletService
    )
    {
    }

    public function index()
    {
        $page = request()->get('page', 1);
        $wallets = Wallet::paginate();
        return Cache::remember("wallets:page:{$page}", 60, function () use ($wallets) {
            return $wallets;
        });
    }

    public function store(WalletData $createWalletDTO)
    {
        try {
            $this->walletService->create($createWalletDTO);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Wallet $wallet)
    {
        return Cache::remember("wallets:id:{$wallet->id}", 60, function () use ($wallet) {
            return [
                'data' => $wallet,
            ];
        });
    }

    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    public function destroy(Wallet $wallet)
    {
        try {
            $this->walletService->delete($wallet);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
