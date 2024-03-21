<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\TransactionData;
use App\Exceptions\InsufficientFundException;
use App\Models\Wallet;
use App\Services\WalletService;
use Cknow\Money\Money;

class PaymentController extends Controller
{
    public function __construct(
        public readonly WalletService $walletService,
    ) {
    }

    /**
     * @throws InsufficientFundException
     * @throws \Throwable
     */
    public function store(TransactionData $transactionData)
    {

        $from = Wallet::findByUuid($transactionData->from)->first();

        $to = Wallet::findByUuid($transactionData->to)->first();

        $amount = Money::MMK($transactionData->amount, true);

        $this->walletService->transfer(
            from: $from,
            to: $to,
            amount: $amount,
            meta: $transactionData->meta,
        );

        return response()->json([
            'message' => 'Payment created successfully',
        ], 201);
    }
}
