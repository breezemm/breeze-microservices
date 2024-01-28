<?php

namespace App\Enums;

enum BuyerType: string
{
    case USER = 'user';
    case GUEST = 'guest';
}
