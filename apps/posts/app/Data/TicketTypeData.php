<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use App\Rules\DigitRangeRule;

class TicketTypeData extends Data
{

    public function __construct(
        public string          $name,
        #[Rule(new DigitRangeRule())]
        public int             $quantity,
        public ?array          $benefits,
        public ?float          $price,
        #[DataCollectionOf(PhaseData::class)]
        public ?DataCollection $phases,
    )
    {
    }

}
