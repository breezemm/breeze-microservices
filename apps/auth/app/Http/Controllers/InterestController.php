<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InterestResource;
use App\Models\Interest;
use Illuminate\Support\Facades\Cache;

class InterestController extends Controller
{
    public function __invoke()
    {
        $interests = Interest::all();

        return Cache::remember('interests', 3600, function () use ($interests) {
            return InterestResource::collection($interests);
        });
    }
}
