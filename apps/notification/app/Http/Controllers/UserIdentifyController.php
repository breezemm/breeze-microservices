<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserIdentifyRequest;
use App\Models\User;

class UserIdentifyController extends Controller
{
    public function create(UserIdentifyRequest $request)
    {
        $validated = $request->validated();
        User::create($validated);
    }

    public function update(UserIdentifyRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($validated);
    }
}
