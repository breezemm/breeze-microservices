<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\DataTransferObjects;

use Spatie\LaravelData\Data;

class OAuthIntrospectionResponse extends Data
{
    public function __construct(
        public bool  $active,
        public array $scopes = [],
    )
    {
    }
}
