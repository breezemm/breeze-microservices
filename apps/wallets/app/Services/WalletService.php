<?php

namespace App\Services;

use App\Contracts\WalletInterface;

final readonly class WalletService implements WalletInterface
{

    public function deposit(float|int $amount): float|int
    {

    }

    public function withdraw(float|int $amount): float|int
    {
        // TODO: Implement withdraw() method.
    }

    public function balance(): float|int
    {
        // TODO: Implement balance() method.
    }

    public function transfer(WalletInterface $wallet, float|int $amount): float|int
    {
        // TODO: Implement transfer() method.
    }
}
