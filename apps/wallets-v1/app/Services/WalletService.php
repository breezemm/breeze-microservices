<?php

namespace App\Services;

use App\Enums\WalletType;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use function Laravel\Prompts\error;

class WalletService
{
    /**
     * @throws \Exception
     */
    public function create(#[ArrayShape(['user_id' => 'int'])] array $user): void
    {
        try {
            DB::beginTransaction();
            Wallet::create([
                'user_id' => $user['user_id'],
                'wallet_id' => Str::uuid(),
                'balance' => 0,
                'type' => WalletType::DEBIT,
                'qr_code' => Str::uuid(),
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws \Exception
     * @return Wallet[]
     */
    public function transferMoney(int $senderUserId, int $receiverUserId, float $amount): array
    {
        try {
            DB::beginTransaction();

            $senderWallet = Wallet::where('user_id', $senderUserId)
                ->where('type', WalletType::DEBIT)
                ->first();

            if (!$this->hasEnoughBalance($senderWallet, $amount)) {
                error('Insufficient balance: Sender User ID ' . $senderUserId . ' ' . $amount);
                throw new \Exception('Insufficient balance');
            }

            $receiverWallet = Wallet::where('user_id', $receiverUserId)
                ->where('type', WalletType::DEBIT)
                ->first();

            if ($senderWallet->wallet_id === $receiverWallet->wallet_id) {
                throw new \Exception('Same wallet transfer');
            }

            // Deduct from the sender's wallet
            $senderWallet->balance = (float)$senderWallet->balance - $amount;
            $senderWallet->save();

            // Add to the receiver's wallet
            $receiverWallet->balance = (float)$receiverWallet->balance + $amount;
            $receiverWallet->save();

            DB::commit();

            return [
                $senderWallet,
                $receiverWallet
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function hasEnoughBalance(Wallet $wallet, float $amount): bool
    {
        return $wallet->balance >= $amount;
    }
}
