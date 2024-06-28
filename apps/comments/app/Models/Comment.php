<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kra8\Snowflake\HasSnowflakePrimary;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Comment extends Model
{
    use HasSnowflakePrimary;
    use InteractsWithMedia, HasRecursiveRelationships;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ];



    public function getParentKeyName(): string
    {
        return 'parent_id';
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }


}
