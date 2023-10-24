<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InterestResource;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function __invoke()
    {
        $interests = Interest::all();

        return InterestResource::collection($interests);
    }
}
