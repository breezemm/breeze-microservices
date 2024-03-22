<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    public function __construct(
        public readonly int $senderWalletId,
        public readonly int $receiverWalletId,
        public readonly float $amount,
        public readonly ?array $meta = null,
    ) {
    }
}
