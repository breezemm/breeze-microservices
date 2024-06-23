<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SavedPost;
use Exception;

class UnSavePostController extends Controller
{
    public function __invoke(Post $post)
    {
        try {
            $isSaved = SavedPost::where('user_id', auth()->id())
                ->where('post_id', $post->id)
                ->exists();

            abort_unless($isSaved, 400, 'Post not saved');

            SavedPost::where('post_id', $post->id)
                ->where('user_id', auth()->id())
                ->delete();

            return response()->noContent();
        } catch (Exception) {
            return response()->json([
                'message' => 'Failed to unsave post'
            ], 500);
        }
    }
}
