<?php

namespace App\DataTransferObjects;

use Cknow\Money\Rules\Currency;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class WalletData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly int $user_id,

        #[Rule([new Currency()])]
        public readonly string $currency,
        public readonly ?array $meta = null,
    ) {
    }
}
