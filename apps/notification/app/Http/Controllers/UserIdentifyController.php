<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserIdentifyDTO;
use App\Http\Requests\UserIdentifyRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserIdentifyController extends Controller
{
    public function __invoke(UserIdentifyRequest $request)
    {
        return User::create($request->validated());
    }
}
