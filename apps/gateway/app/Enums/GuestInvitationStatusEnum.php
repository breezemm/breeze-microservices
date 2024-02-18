<?php

namespace App\Enums;

enum GuestInvitationStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';
}
