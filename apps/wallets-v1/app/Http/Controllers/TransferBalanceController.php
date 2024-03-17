<?php

namespace app\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\DataTransferObjects\TransferBalanceDTO;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class TransferBalanceController extends Controller
{
    public function __invoke(TransferBalanceDTO $transferBalanceDTO)
    {

        // check if the user has enough balance to transfer
        if (!$this->hasEnoughBalance($transferBalanceDTO->from_wallet_id, $transferBalanceDTO->transaction_amount)) {
            return response()->json([
                'message' => 'Insufficient balance',
            ], 400);
        }

        try {
            DB::beginTransaction();
            $transaction = $this->createTransaction($transferBalanceDTO);

            // if the transaction type is DEPOSIT, then add the transaction amount to the to_wallet_id
            // and subtract the transaction amount from the from_wallet_id
            $from_wallet = Wallet::where('wallet_id', $transferBalanceDTO->from_wallet_id)->first();
            $from_wallet->balance = (float)$from_wallet->balance - (float)$transferBalanceDTO->transaction_amount;
            $from_wallet->save();

            $to_wallet = Wallet::where('wallet_id', $transferBalanceDTO->to_wallet_id)->first();
            $to_wallet->balance = (float)$to_wallet->balance + (float)$transferBalanceDTO->transaction_amount;
            $to_wallet->save();

            DB::commit();
            return response()->json([
                'message' => 'Payment Transfer successful',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            info('[ERROR]' . $exception->getMessage());
            return response()->json([
                'message' => 'Failed to transfer balance, please try again later',
            ], 500);
        }
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
            'transaction_type' => TransactionType::TRANSFER,

            'transaction_amount' => $transferBalanceDTO->transaction_amount,
            'transaction_currency' => $transferBalanceDTO->transaction_currency,
            'transaction_description' => $transferBalanceDTO->transaction_description,

            'from_wallet_id' => $transferBalanceDTO->from_wallet_id,
            'to_wallet_id' => $transferBalanceDTO->to_wallet_id,
        ]);
    }


}
