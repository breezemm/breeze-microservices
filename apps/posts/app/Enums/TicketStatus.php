<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Available = 'available';
    case Unavailable = 'unavailable';
    case Sold = 'sold';
}
