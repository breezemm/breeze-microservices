<?php

namespace App\States;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class BuyerTypeState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(BuyerTypeUser::class)
            ->allowTransition(BuyerTypeUser::class, BuyerTypeGuest::class);
    }
}
