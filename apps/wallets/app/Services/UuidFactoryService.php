<?php

namespace App\Services;

use App\Contracts\UuidFactory;
use Godruoyi\Snowflake\Snowflake;

final readonly class UuidFactoryService implements UuidFactory
{

    public function __construct(
        private readonly Snowflake $snowflake
    )
    {
        //
    }

    public function generate(): string
    {
        return $this->snowflake->id();
    }
}
