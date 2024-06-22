<?php

namespace App\Http\Controllers;

use App\Actions\CreatePost;
use App\Data\PostData;

class CreatePostController extends Controller
{
    public function __invoke(PostData $postData, CreatePost $createPost)
    {
        $createPost->handle($postData);

        return response()->json([
            'message' => 'Post created successfully',
        ]);
    }
}
