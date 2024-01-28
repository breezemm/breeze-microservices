<?php

namespace App\Models;

use App\Enums\BuyerType;
use App\Enums\GuestInvitationStatus;
use App\Enums\QRCodeStatus;
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
        'qr_code_status' => QRCodeStatus::class,
        'buyer_type' => BuyerType::class,
        'guest_invitation_status' => GuestInvitationStatus::class,
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
