<?php

namespace App\Packages\OTP;

enum OTPType: string
{
    case Numeric = 'numeric';
    case Alphanumeric = 'alphanumeric';
}
