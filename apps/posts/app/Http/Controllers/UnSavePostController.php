<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SavedPost;

class UnSavePostController extends Controller
{
    public function __invoke(Post $post)
    {
        SavedPost::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->noContent();
    }
}
