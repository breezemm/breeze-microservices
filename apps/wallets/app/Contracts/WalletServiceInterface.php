<?php

namespace App\Contracts;

use App\Models\Wallet;
use Cknow\Money\Money;

interface WalletServiceInterface
{
    public function transfer(Wallet $from, Wallet $to, Money $amount): ?Wallet;

    public function withdraw(Wallet $wallet, Money $amount): ?Wallet;

    public function deposit(Wallet $wallet, Money $amount): ?Wallet;

    public function delete(Wallet $wallet);
}
