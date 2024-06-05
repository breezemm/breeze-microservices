<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * @unauthenticated
     * Reset password for the user.
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::where('email', $request->email)->first();

            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->setRememberToken(Str::random(60));

            $user->save();
            DB::commit();

            return response()->json(['message' => 'Password changed successfully']);
        } catch (Exception) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
