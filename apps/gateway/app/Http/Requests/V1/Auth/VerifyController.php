<?php

namespace App\Http\Requests\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;

class VerifyController extends Controller
{
    public function __invoke(ValidationRequest $request)
    {
        if (!$request->validated()) {
            abort(422, 'Validation failed');
        }

        try {
            VerificationCode::where(
                fn($query) => $query->where('email', $request->email)
                    ->orWhere('phone', $request->phone)
            )
                ->where('code', $request->code)
                ->where('type', $request->type)
                ->firstOrFail();

            return response()->json([
                'message' => 'Verification Code is valid'
            ]);
        } catch (\Exception $exception) {
            abort(422, 'Verification Code is not valid');
        }

    }
}
