<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class CreateWalletData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string|int $user_id,
        public readonly string $currency,
    ) {
    }
}
