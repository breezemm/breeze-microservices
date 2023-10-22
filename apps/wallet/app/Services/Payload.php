<?php

namespace App\Services;

use JetBrains\PhpStorm\ArrayShape;

class Payload
{
    public function __construct(
        public readonly string $id,
        public readonly string $topic,
        #[ArrayShape(["cmd" => "string"])]
        public readonly array  $pattern,
        public readonly array  $data,
    )
    {
    }
}
