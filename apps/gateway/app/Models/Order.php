<?php

namespace App\Models;

use App\Enums\BuyerTypeEnum;
use App\Enums\GuestInvitationStatusEnum;
use App\Enums\QRCodeStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'qr_code',
        'qr_code_status',
        'buyer_type',
        'guest_invitation_status',
    ];

    protected $casts = [
        'qr_code_status' => QRCodeStatusEnum::class,
        'buyer_type' => BuyerTypeEnum::class,
        'guest_invitation_status' => GuestInvitationStatusEnum::class,
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
