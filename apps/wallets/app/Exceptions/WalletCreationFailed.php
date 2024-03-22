<?php

namespace App\Exceptions;

use Exception;

class WalletCreationFailed extends Exception
{
    protected $message = 'Wallet creation failed';
}
