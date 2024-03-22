<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case DEPOSIT = 'DEPOSIT';
    case WITHDRAW = 'WITHDRAW';

    case TRANSFER = 'TRANSFER';

}
