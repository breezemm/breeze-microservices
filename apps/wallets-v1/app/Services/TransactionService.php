<?php

namespace App\Services;

use App\Enums\CurrencyType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function create(array $data): Transaction
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'sender_user_id' => $data['sender_user_id'],
                'receiver_user_id' => $data['receiver_user_id'],

                'sender_wallet_id' => $data['sender_wallet_id'],
                'receiver_wallet_id' => $data['receiver_wallet_id'],

                'transaction_type' => $data['transaction_type'],
                'transaction_amount' => $data['transaction_amount'],
                'transaction_currency' => $data['transaction_currency'],
            ]);
            DB::commit();
            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
