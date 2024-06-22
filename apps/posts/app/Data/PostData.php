<?php

namespace App\Data;

use App\Rules\Base64ValidationRule;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class PostData extends Data
{
    public function __construct(
        public string         $name,
        #[Rule(['required', 'date_format:Y-m-d'])]
        public string         $date,
        #[Rule(['required', 'date_format:H:i'])]
        public string         $startTime,
        #[Rule(['required', 'date_format:H:i'])]
        public string         $endTime,
        public string         $address,
        public string         $city,
        public array          $interests,
        #[Rule(['required', new Base64ValidationRule])]
        public string         $image,
        public string         $description,
        public bool           $terms,

        #[DataCollectionOf(TicketTypeData::class)]
        public DataCollection $ticketTypes,
    )
    {
    }

}
