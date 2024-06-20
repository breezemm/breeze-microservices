<?php

namespace App\Enums;

enum TicketStatus: string
{
    case InStock = 'in_stock';
    case Unavailable = 'unavailable';
    case Sold = 'sold';
}

