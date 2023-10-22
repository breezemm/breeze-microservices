<?php

namespace App\Enums;

enum TransactionType: string
{
    case DEPOSIT = 'DEPOSIT';
    case WITHDRAW = 'WITHDRAW';

    public static function getValues(): array
    {
        return [
            self::DEPOSIT,
            self::WITHDRAW,
        ];
    }

}
