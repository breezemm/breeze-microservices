<?php

namespace App\Exceptions;

use Exception;

class InvalidAmountException extends Exception
{
    protected $message = 'Invalid amount.';
}
