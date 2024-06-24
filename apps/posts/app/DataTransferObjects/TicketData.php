<?php

namespace App\DataTransferObjects;

use App\States\TicketState;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\ModelStates\Validation\ValidStateRule;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class TicketData extends Data
{
    public function __construct(
        #[Rule(new ValidStateRule(TicketState::class))]
        public string $availableState,
        public string $note,
    )
    {
    }
}
