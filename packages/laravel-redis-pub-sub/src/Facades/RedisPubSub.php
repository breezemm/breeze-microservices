<?php

namespace MyanmarCyberYouths\RedisPubSub\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MyanmarCyberYouths\RedisPubSub\RedisPubSub
 */
class RedisPubSub extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MyanmarCyberYouths\RedisPubSub\RedisPubSub::class;
    }
}
