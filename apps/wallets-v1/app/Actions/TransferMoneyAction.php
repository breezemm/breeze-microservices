<?php

namespace App\Actions;

use App\Enums\CurrencyType;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class TransferMoneyAction implements ActionInterface
{

    public function __construct(
        private readonly WalletService      $walletService,
        private readonly TransactionService $transactionService
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function execute(array $data): void
    {
        $senderUserId = $data['sender_user_id'];
        $receiverUserId = $data['receiver_user_id'];
        $amount = $data['amount'];

        [$senderWallet, $receiverWallet] = $this->walletService->transferMoney(
            senderUserId: $senderUserId,
            receiverUserId: $receiverUserId,
            amount: $amount
        );

        $transaction = $this->transactionService->create([
            'sender_user_id' => $senderUserId,
            'receiver_user_id' => $receiverUserId,

            'sender_wallet_id' => $senderWallet->wallet_id,
            'receiver_wallet_id' => $receiverWallet->wallet_id,

            'transaction_type' => TransactionType::TRANSFER,
            'transaction_amount' => $amount,
            'transaction_currency' => CurrencyType::MMK,
        ]);

        info('Transaction created: ' . $transaction->id);

    }

}
