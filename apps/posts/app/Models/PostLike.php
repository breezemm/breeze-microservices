<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeAttachLikeStatus(Builder $query, int $userId): Builder
    {
        return $query->addSelect([
            'liked' => PostLike::select('id')
                ->whereColumn('post_id', 'posts.id')
                ->where('user_id', $userId)
                ->limit(1),
        ]);

    }


}
