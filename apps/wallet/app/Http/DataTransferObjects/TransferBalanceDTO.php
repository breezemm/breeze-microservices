<?php

namespace App\Http\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

class TransferBalanceDTO extends Data
{
    public function __construct(
        public readonly string $transaction_type,
        public readonly string $transaction_amount,
        public readonly string $transaction_currency,
        public readonly string $transaction_description,
        public readonly string $from_wallet_id,
        public readonly string $to_wallet_id,
        public readonly string $transaction_id,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'transaction_type' => 'required|in:DEPOSIT,WITHDRAW',
            'transaction_amount' => 'required|string',
            'transaction_currency' => 'required|string|in:MMK,USD',
            'transaction_description' => 'required|string',
            'from_wallet_id' => 'required|string|exists:wallets,wallet_id',
            'to_wallet_id' => 'required|string|exists:wallets,wallet_id',
            'transaction_id' => 'required|string|unique:transactions,transaction_id',
        ];
    }


}
