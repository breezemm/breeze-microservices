<?php

namespace App\Enums;

enum QRCodeStatusEnum: string
{
    case PENDING = 'pending';
    case USED = 'used';
}
