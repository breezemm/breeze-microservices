<?php

namespace App\Services;

use App\Enums\WalletType;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class WalletService
{
    /**
     * @throws \Exception
     */
    public function create(#[ArrayShape(['user_id' => 'int'])] array $data): void
    {
        try {
            DB::beginTransaction();
            Wallet::create([
                'user_id' => $data['user_id'],
                'wallet_id' => Str::uuid(),
                'balance' => 0,
                'type' => WalletType::DEBIT,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function findAll()
    {
    }
}
