<?php

namespace App\Contracts;

interface WalletInterface
{
    public function deposit(int|float $amount): float|int;

    public function withdraw(int|float $amount): float|int;

    public function balance(): float|int;

    public function transfer(WalletInterface $wallet, int|float $amount): float|int;

}
