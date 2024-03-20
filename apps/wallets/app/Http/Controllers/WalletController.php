<?php

namespace App\Http\Controllers;

use App\Contracts\WalletServiceInterface;
use App\DataTransferObjects\WalletData;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WalletController extends Controller
{

    public function __construct(
        public readonly WalletServiceInterface $walletService
    )
    {
    }

    public function index()
    {
        $page = request()->get('page', 1);
        $wallets = Wallet::paginate();
        return Cache::remember("wallets:{$page}", 60, function () use ($wallets) {
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
        return Cache::remember("wallet:{$wallet->id}", 60, function () use ($wallet) {
            return $wallet;
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
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
