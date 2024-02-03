<?php

namespace App\Actions;

use App\Enums\CurrencyType;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

class TransferMoneyAction
{
    /**
     * @throws \Exception
     */
    public function handle(int $fromUserId, int $toUserId, float $amount): void
    {
        try {
            DB::beginTransaction();
            if (!$this->hasEnoughBalance($fromUserId, $amount)) {
                error('Insufficient balance: User ID ' . $fromUserId . ' ' . $amount);

                throw new \Exception('Insufficient balance');
            }

            $fromWallet = Wallet::where('user_id', $fromUserId)
                ->where('type', WalletType::DEBIT)
                ->first();

            $fromWallet->balance = (float)$fromWallet->balance - $amount;
            $fromWallet->save();


            $toWallet = Wallet::where('user_id', $toUserId)
                ->where('type', WalletType::DEBIT)
                ->first();

            $toWallet->balance = (float)$toWallet->balance + $amount;
            $toWallet->save();

            $transaction = Transaction::create([
                'from_user' => $fromUserId,
                'to_user' => $toUserId,

                'from_wallet_id' => $fromWallet->wallet_id,
                'to_wallet_id' => $toWallet->wallet_id,

                'transaction_type' => TransactionType::TRANSFER,
                'transaction_amount' => $amount,
                'transaction_currency' => CurrencyType::MMK,
            ]);
            info('Transaction created: ' . $transaction->transaction_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    private function hasEnoughBalance(int $fromUserId, float $amount): bool
    {
        $wallet = Wallet::where('user_id', $fromUserId)
            ->where('type', WalletType::DEBIT)
            ->first();
        return $wallet->balance >= $amount;
    }
}
