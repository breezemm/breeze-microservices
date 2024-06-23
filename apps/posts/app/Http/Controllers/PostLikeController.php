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

        $isLikedPost = PostLike::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->exists();

        abort_if($isLikedPost, "You already liked");

        PostLike::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        return response()->json([
            'message' => 'Post liked successfully',
        ]);
    }
}
