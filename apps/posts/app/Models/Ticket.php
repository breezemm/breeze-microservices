<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\States\BuyerTypeState;
use App\States\InvitationState;
use App\States\TicketState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStates\HasStates;

class Ticket extends Model
{
    use HasFactory, HasStates;

    protected $fillable = [
        'user_id',
        'post_id',
        'ticket_type_id',
        'seat_no',
        'note',
        'available_state',
        'invitation_state',
        'buyer_state',
    ];

    protected function casts(): array
    {
        return [
            'available_state' => TicketState::class,
            'invitation_state' => InvitationState::class,
            'buyer_state' => BuyerTypeState::class,
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }
}
