<?php

namespace App\Common;

enum OTPType: string
{
    case Numeric = 'numeric';
    case Alphanumeric = 'alphanumeric';
}
