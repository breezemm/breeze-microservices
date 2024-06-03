<?php

namespace MyanmarCyberYouths\Breeze\Auth;

trait GuardHelper
{

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id(): int|string|null
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }
        return null;
    }

}
