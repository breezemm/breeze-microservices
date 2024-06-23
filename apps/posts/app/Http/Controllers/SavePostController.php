<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SavedPost;

class SavePostController extends Controller
{
    public function __invoke(Post $post)
    {
        $isSaved = SavedPost::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->exists();

        abort_if($isSaved, 400, 'Post already saved');

        SavedPost::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        return response()->json([
            'message' => 'Post saved successfully',
        ]);
    }
}
