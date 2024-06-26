<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CreateReplyData extends Data
{
    public function __construct(
        public int  $postId,
        #[Exists('comments', 'id')]
        public int  $parentId,
        public string  $content,
        public ?string $image,
    )
    {
    }
}
