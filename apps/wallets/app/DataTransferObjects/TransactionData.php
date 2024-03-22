<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        public mixed $amount,
        #[Exists('wallets', 'uuid')]
        public string $from,
        #[Exists('wallets', 'uuid')]
        public string $to,
        public ?array $meta = null,
    ) {
    }
}
