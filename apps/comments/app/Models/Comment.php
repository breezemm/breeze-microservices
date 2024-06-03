<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Comment extends Model
{
    use InteractsWithMedia;
    use HasRecursiveRelationships;


    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
        'parent_id',
    ];

    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }


    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

}
