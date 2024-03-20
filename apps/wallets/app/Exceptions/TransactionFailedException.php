<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionFailedException extends Exception
{

    protected $message = 'Transaction failed.';

    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $this->message], 500);
    }
}
