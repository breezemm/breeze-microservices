<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Expr\AssignOp\Mod;

class NotificationList extends Model
{
    protected $fillable = [
        'user_id', // The ID of the user in your system. Required.
        'message',
        'is_read',
    ];

    protected $casts = [
        'message' => 'array',
        'is_read' => 'boolean',
    ];


    public function scopeMarkedAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }
}
