<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsufficientFundException extends Exception
{
    protected $message = 'Insufficient fund in your account.';

}
