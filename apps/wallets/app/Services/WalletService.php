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
     * @throws \Throwable
     */
    public function transfer(Wallet $from, Wallet $to, Money $amount): Wallet
    {
        throw_if($from->balance->lessThan($amount), new InsufficientFundException('Insufficient fund'));

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


    public function withdraw(Wallet $wallet, Money $amount): ?Wallet
    {
        return $wallet->withdraw($amount);
    }

    public function deposit(Wallet $wallet, Money $amount): ?Wallet
    {
        return $wallet->deposit($amount);
    }
}

