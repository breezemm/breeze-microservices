<?php

namespace App\Support;

use JetBrains\PhpStorm\ArrayShape;

class Payload
{
    public function __construct(
        public readonly string $id,
        public readonly string $topic,
        public readonly mixed  $pattern,
        public readonly array  $data,
    )
    {
    }


}
