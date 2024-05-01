<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function render(Request $request): JsonResponse
    {
        return response()->json(['error' => $this->message], 500);
    }
}
