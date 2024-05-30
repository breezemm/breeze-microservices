<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CreateCommentController extends Controller
{
    public function __invoke(CreateCommentRequest $createCommentRequest)
    {
        Comment::query()->create($createCommentRequest->validated());
    }
}
