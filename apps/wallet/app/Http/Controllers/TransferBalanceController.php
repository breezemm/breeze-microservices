<?php

namespace app\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\DataTransferObjects\TransferBalanceDTO;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Str;

class TransferBalanceController extends Controller
{
    public function __invoke(TransferBalanceDTO $transferBalanceDTO)
    {
        // check if the transaction ID has been processed before
        if ($this->transactionIdExists($transferBalanceDTO->transaction_id)) {
            return response()->json([
                'message' => 'Transaction already exists',
            ], 400);
        }

        // check if the user has enough balance to transfer
        if (!$this->hasEnoughBalance($transferBalanceDTO->from_wallet_id, $transferBalanceDTO->transaction_amount)) {
            return response()->json([
                'message' => 'Insufficient balance',
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
                'message' => 'Deposit Transaction successful',
            ]);
        }


        return response()->json([
            'message' => 'Invalid transaction type',
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
        $fromWallet = Wallet::where('wallet_id', $transferBalanceDTO->from_wallet_id)->first();
        $toWallet = Wallet::where('wallet_id', $transferBalanceDTO->to_wallet_id)->first();

        return Transaction::create([
            'from_user' => $fromWallet->user_id,
            'to_user' => $toWallet->user_id,
            'transaction_type' => $transferBalanceDTO->transaction_type,

            'transaction_amount' => $transferBalanceDTO->transaction_amount,
            'transaction_currency' => $transferBalanceDTO->transaction_currency,
            'transaction_description' => $transferBalanceDTO->transaction_description,

            'from_wallet_id' => $transferBalanceDTO->from_wallet_id,
            'to_wallet_id' => $transferBalanceDTO->to_wallet_id,
        ]);
    }


}
