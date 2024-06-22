<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostUnLikeController extends Controller
{
    public function __invoke(Post $post)
    {
        PostLike::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->delete();
    }
}
