<?php

namespace App\Http\Controllers;

use App\Enums\WalletType;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {

        Wallet::create([
            'user_id' => '1',
            'wallet_id' => Str::uuid(),
            'balance' => 0,
            'type' => WalletType::DEBIT,
        ]);


        $wallet = Wallet::where('user_id', $user->id)->first();

        return response()->json([
            'meta' => [
                'status' => 200,
            ],
            'data' => $wallet,
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
