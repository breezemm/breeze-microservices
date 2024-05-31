<?php

namespace MyanmarCyberYouths\BreezeSdk\Connectors\DataTransferObjects;

use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Traits\Responses\HasResponse;

class OauthIntrospectResponse implements WithResponse
{
    use HasResponse;

    public function __construct(
        public readonly bool $active,
    )
    {
    }
}
