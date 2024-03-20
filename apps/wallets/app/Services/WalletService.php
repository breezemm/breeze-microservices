<?php

namespace App\Services;

use App\Contracts\WalletServiceInterface;
use App\Exceptions\InsufficientFundException;
use App\Models\Wallet;
use Cknow\Money\Money;
use Illuminate\Support\Facades\DB;

class WalletService implements WalletServiceInterface
{

    public function create()
    {

    }

    /**
     * @throws InsufficientFundException If the wallet has insufficient fund
     * @throws \Exception
     */
    public function transfer(Wallet $from, Wallet $to, Money $amount): Wallet
    {
        if ($from->balance->lessThan($amount)) {
            throw new InsufficientFundException();
        }

        try {
            DB::beginTransaction();

            $this->withdraw($from, $amount);
            $this->deposit($to, $amount);

            DB::commit();
            return $from;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function withdraw(Wallet $wallet, Money $amount): Wallet
    {
        try {
            DB::beginTransaction();
            $wallet->balance = $wallet->balance->subtract($amount);
            $wallet->save();
            DB::commit();
            return $wallet;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function deposit(Wallet $wallet, Money $amount): Wallet
    {
        try {
            DB::beginTransaction();
            $wallet->balance = $wallet->balance->add($amount);
            $wallet->save();
            DB::commit();
            return $wallet;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
