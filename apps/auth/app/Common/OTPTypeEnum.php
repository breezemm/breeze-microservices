<?php

namespace App\Common;

enum OTPTypeEnum: string
{
    case Numeric = 'numeric';
    case Alphanumeric = 'alphanumeric';
}
