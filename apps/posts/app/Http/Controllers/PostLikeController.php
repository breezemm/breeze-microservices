<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        PostLike::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);
    }
}
