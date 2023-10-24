<?php

namespace App\Http\Controllers;

use App\Enums\WalletType;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    public function index(User $user)
    {
        $wallets = $user->load('wallets');

        return response()->json([
            'meta' => [
                'status' => 200,
            ],
            'data' => [
                'wallets' => $wallets->wallets,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet, User $user)
    {
        $wallet = Wallet::where('user_id', $user->id)->first();

        return response()->json([
            'meta' => [
                'status' => 200,
            ],
            'data' => $wallet,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
