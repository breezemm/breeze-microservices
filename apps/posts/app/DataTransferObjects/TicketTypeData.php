<?php

namespace App\DataTransferObjects;

use App\Rules\DigitRangeRule;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\Computed;

class TicketTypeData extends Data
{
    #[Computed]
    public bool $isFreeTicket;
    #[Computed]
    public bool $isPaidTicket;

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
        $this->isFreeTicket = $this->quantity === 1 && $this->price === 0.0;
        $this->isPaidTicket = !$this->isFreeTicket;
    }


}
