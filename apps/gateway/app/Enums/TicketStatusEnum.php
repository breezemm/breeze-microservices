<?php

namespace App\Enums;

enum TicketStatusEnum: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case SOLD = 'sold';
}
