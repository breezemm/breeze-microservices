<?php

namespace app\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\TransferBalanceDTO;
use App\Models\Transaction;
use App\Models\Wallet;

class TransferBalanceController extends Controller
{
    public function __invoke(TransferBalanceDTO $transferBalanceDTO)
    {
        // check if the transaction ID has been processed before
        if ($this->transactionIdExists($transferBalanceDTO->transaction_id)) {
            return response()->json([
                'meta' => [
                    'status' => 400,
                    'message' => 'Transaction ID already exists',
                ],
                'data' => [],
            ], 400);
        }

        // check if the user has enough balance to transfer
        if (!$this->hasEnoughBalance($transferBalanceDTO->from_wallet_id, $transferBalanceDTO->transaction_amount)) {
            return response()->json([
                'meta' => [
                    'status' => 400,
                    'message' => 'Insufficient balance',
                ],
                'data' => [],
            ], 400);
        }

        // create transaction
        $transaction = $this->createTransaction($transferBalanceDTO);

        // if the transaction type is DEPOSIT, then add the transaction amount to the to_wallet_id
        // and subtract the transaction amount from the from_wallet_id
        if ($transferBalanceDTO->transaction_type === TransactionType::DEPOSIT->value) {
            $from_wallet = Wallet::where('wallet_id', $transferBalanceDTO->from_wallet_id)->first();
            $from_wallet->balance = (float)$from_wallet->balance - (float)$transferBalanceDTO->transaction_amount;
            $from_wallet->save();

            $to_wallet = Wallet::where('wallet_id', $transferBalanceDTO->to_wallet_id)->first();
            $to_wallet->balance = (float)$to_wallet->balance + (float)$transferBalanceDTO->transaction_amount;
            $to_wallet->save();

            return response()->json([
                'meta' => [
                    'status' => 200,
                    'message' => 'Transaction successful',
                ],
                'data' => [
                    'transaction' => $transaction,
                ],
            ], 200);
        }

        // if the transaction type is WITHDRAW, then subtract the transaction amount from the to_wallet_id
        // and add the transaction amount to the from_wallet_id
        if ($transferBalanceDTO->transaction_type === TransactionType::WITHDRAW->value) {
            $from_wallet = Wallet::where('wallet_id', $transferBalanceDTO->from_wallet_id)->first();
            $from_wallet->balance = (float)$from_wallet->balance + (float)$transferBalanceDTO->transaction_amount;
            $from_wallet->save();

            $to_wallet = Wallet::where('wallet_id', $transferBalanceDTO->to_wallet_id)->first();
            $to_wallet->balance = (float)$to_wallet->balance - (float)$transferBalanceDTO->transaction_amount;
            $to_wallet->save();

            return response()->json([
                'meta' => [
                    'status' => 200,
                    'message' => 'Transaction successful',
                ],
                'data' => [
                    'transaction' => $transaction,
                ],
            ], 200);
        }

        return response()->json([
            'meta' => [
                'status' => 400,
                'message' => 'Invalid transaction type',
            ],
            'data' => [],
        ], 400);
    }

    private function transactionIdExists(string $transaction_id)
    {
        return Transaction::where('transaction_id', $transaction_id)->exists();
    }

    private function hasEnoughBalance(string $from_wallet_id, string $transaction_amount)
    {
        $wallet = Wallet::where('wallet_id', $from_wallet_id)->first();
        return $wallet->balance >= $transaction_amount;
    }

    private function createTransaction(TransferBalanceDTO $transferBalanceDTO)
    {
        return Transaction::create([
            'transaction_id' => $transferBalanceDTO->transaction_id,
            'from_user' => $transferBalanceDTO->from_user,
            'to_user' => $transferBalanceDTO->to_user,
            'transaction_type' => $transferBalanceDTO->transaction_type,

            'transaction_amount' => $transferBalanceDTO->transaction_amount,
            'transaction_currency' => $transferBalanceDTO->transaction_currency,
            'transaction_description' => $transferBalanceDTO->transaction_description,

            'from_wallet_id' => $transferBalanceDTO->from_wallet_id,
            'to_wallet_id' => $transferBalanceDTO->to_wallet_id,
        ]);
    }


}
