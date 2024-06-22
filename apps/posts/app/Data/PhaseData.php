<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class PhaseData extends Data
{

    public function __construct(
        public string $name,
        #[Rule(['required', 'date_format:Y-m-d'])]
        public string $startDate,
        #[Rule(['required', 'date_format:Y-m-d'])]
        public string $endDate,
        public float  $price,
    )
    {
    }

}
