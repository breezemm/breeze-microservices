<?php

namespace App\Http\Controllers;

use App\Actions\CreatePost;
use App\DataTransferObjects\PostData;
use App\Rules\Base64ValidationRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreatePostController extends Controller
{
    public function __invoke(Request $request, PostData $postData, CreatePost $createPost)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'image' => ['required', 'string', new Base64ValidationRule()],
            ]);

            $post = $createPost->handle($postData);

            $post->addMediaFromBase64($request->image)
                ->toMediaCollection('post_images');

            DB::commit();

            return response()->json([
                'message' => 'Post created successfully',
            ], 201);
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error('Post creation failed', ['exception' => $exception]);

            return response()->json([
                'message' => 'Post creat failed.'
            ]);
        }

    }
}
