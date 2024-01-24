<?php

namespace App\Enums;

enum TicketStatus: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case SOLD = 'sold';
}
