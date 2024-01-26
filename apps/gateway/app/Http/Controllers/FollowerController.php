<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->user()->followers()->paginate(10);
    }
}
