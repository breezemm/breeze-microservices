<?php

namespace App\Actions;

use App\Enums\CurrencyType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class TransferMoneyAction
{

    public function __construct(private readonly WalletService $walletService)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(int $senderUserId, int $receiverUserId, float $amount): void
    {
        try {
            DB::beginTransaction();

            [$senderWallet, $receiverWallet] = $this->walletService->transferMoney(
                senderUserId: $senderUserId,
                receiverUserId: $receiverUserId,
                amount: $amount
            );

            $transaction = Transaction::create([
                'sender_user_id' => $senderUserId,
                'receiver_user_id' => $receiverUserId,

                'sender_wallet_id' => $senderWallet->wallet_id,
                'receiver_wallet_id' => $receiverWallet->wallet_id,

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
}
