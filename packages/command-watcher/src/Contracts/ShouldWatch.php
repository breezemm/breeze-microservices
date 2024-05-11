<?php

namespace MyanmarCyberYouths\CommandWatcher\Contracts;

interface ShouldWatch
{

    /**
     * Get the shell command to watch.
     *
     * @return string
     */
    public function shellCommand(): string;
}
