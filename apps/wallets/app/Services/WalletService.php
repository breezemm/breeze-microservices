<?php

namespace App\Services;

use App\Contracts\WalletServiceInterface;
use App\DataTransferObjects\WalletData;
use App\Enums\WalletType;
use App\Exceptions\InsufficientFundException;
use App\Exceptions\WalletCreationFailed;
use App\Models\Wallet;
use Cknow\Money\Money;
use Illuminate\Support\Facades\DB;

class WalletService implements WalletServiceInterface
{

    /**
     * @throws WalletCreationFailed
     */
    public function create(WalletData $createWalletDTO): void
    {
        try {
            DB::beginTransaction();

            $wallet = [
                ...$createWalletDTO->all(),
                'type' => WalletType::PREPAID,
            ];

            Wallet::create($wallet);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new WalletCreationFailed();
        }

    }

    /**
     * @throws InsufficientFundException If the wallet has insufficient fund
     * @throws \Exception
     * @throws \Throwable
     */
    public function transfer(Wallet $from, Wallet $to, Money $amount): Wallet
    {
        throw_if($from->balance->lessThan($amount), new InsufficientFundException());

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

    public function delete(Wallet $wallet): void
    {
        $wallet->delete();
    }
}

