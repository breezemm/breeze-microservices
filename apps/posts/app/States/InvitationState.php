<?php

namespace App\States;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class InvitationState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(InvitationPending::class)
            ->allowTransition(InvitationPending::class, InvitationAccepted::class)
            ->allowTransition(InvitationPending::class, InvitationDeclined::class);
    }
}
