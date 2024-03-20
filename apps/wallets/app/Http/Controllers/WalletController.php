<?php

namespace App\Http\Controllers;

use App\Contracts\WalletServiceInterface;
use App\Models\Wallet;
use Cknow\Money\Money;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function __construct(
        public readonly WalletServiceInterface $walletService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->walletService->transfer(Wallet::find(1), Wallet::find(2), Money::MMK(1000, true));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
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
