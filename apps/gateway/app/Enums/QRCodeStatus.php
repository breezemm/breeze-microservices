<?php

namespace App\Enums;

enum QRCodeStatus: string
{
    case PENDING = 'pending';
    case USED = 'used';
}
