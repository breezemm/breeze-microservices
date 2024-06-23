<?php

namespace App\Resources;

use App\DataTransferObjects\TicketTypeData;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Resource;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class PostResource extends Resource
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
        public string         $description,
        public bool           $terms,
        #[DataCollectionOf(TicketTypeData::class)]
        public DataCollection $ticketTypes,
    )
    {

    }


}
