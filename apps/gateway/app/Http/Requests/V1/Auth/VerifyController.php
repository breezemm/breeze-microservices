<?php

namespace App\Http\Requests\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;

class VerifyController extends Controller
{
    public function __invoke(ValidationRequest $request)
    {
        if (! $request->validated()) {
            return json_response(422, 'Email (or) Phone Number is not valid');
        }

        try {
            VerificationCode::where(
                fn ($query) => $query->where('email', $request->email)
                    ->orWhere('phone', $request->phone)
            )
                ->where('code', $request->code)
                ->where('type', $request->type)
                ->firstOrFail();

            return json_response(200, 'Verification Code is valid');
        } catch (\Exception $exception) {
            return json_response(422, 'Invalid Verification Code');
        }

    }
}
