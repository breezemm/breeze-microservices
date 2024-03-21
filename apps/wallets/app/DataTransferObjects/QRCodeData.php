<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class QRCodeData extends Data
{
    public function __construct(
        public readonly string $qr_code,
    ) {
    }
}
