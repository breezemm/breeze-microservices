<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserIdentifyRequest;
use App\Models\User;

class UserIdentifyController extends Controller
{
    public function __invoke(UserIdentifyRequest $request)
    {
        return User::create($request->validated());
    }
}
