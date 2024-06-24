<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Collection;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

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
        #[Rule(['required', 'date_format:Y-m-d'])]
        public string         $finalSellingDate,
        #[Rule(['required', 'date_format:H:i'])]
        public string         $finalSellingTime,
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
