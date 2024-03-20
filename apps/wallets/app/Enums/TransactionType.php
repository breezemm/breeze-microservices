<?php

namespace App\Enums;

enum TransactionType: string
{
    case DEPOSIT = 'DEPOSIT';
    case WITHDRAW = 'WITHDRAW';

    case TRANSFER = 'TRANSFER';
}
