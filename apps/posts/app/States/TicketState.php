<?php

namespace App\States;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TicketState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(TicketInStock::class)
            ->allowTransition(TicketInStock::class, TicketSold::class)
            ->allowTransition(TicketInStock::class, TicketUnavailable::class)
            ->allowTransition(TicketUnavailable::class, TicketInStock::class)
            ->allowTransition(TicketInStock::class, TicketUnlimited::class);
    }
}
