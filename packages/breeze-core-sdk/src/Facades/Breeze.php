<?php

namespace MyanmarCyberYouths\Breeze\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MyanmarCyberYouths\Breeze\Breeze
 */
class Breeze extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MyanmarCyberYouths\Breeze\Breeze::class;
    }
}
