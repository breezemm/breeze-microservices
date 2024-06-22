<?php

namespace MyanmarCyberYouths\Breeze\Connectors\Auth\Data;

use Spatie\LaravelData\Data;

class OAuthIntrospectionData extends Data
{
    public function __construct(
        public bool  $active,
        public array $scopes = [],
    )
    {
    }
}
