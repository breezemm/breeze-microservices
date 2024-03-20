<?php

namespace App\Enums;

enum WalletType: string
{
    case CREDIT = 'CREDIT';
    case DEBIT = 'DEBIT';

    case PREPAID = 'PREPAID';
}
