<?php

namespace App\Domains\Events\Exceptions;

use App\Support\DomainException;

class EventCreatedFailed extends DomainException
{
    protected $code = 500;
    protected $message = 'Event created failed';

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
