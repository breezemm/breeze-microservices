<?php

namespace App\Enums;

enum WalletType
{
    case DEBIT;
    case CREDIT;
    case CASH;
    case POINT;
    case COIN;
}
