<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Models\User;
use App\Packages\OTP\OTP;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{
    /**
     * Verify Email OTP
     *
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */

    public function __invoke(EmailVerificationRequest $request)
    {
        $isVerifiedOTP = app(OTP::class)->verify(
            identifier: $request->email,
            otp: $request->code,
        );

        abort_unless($isVerifiedOTP, 422, 'Invalid OTP code');

        $user = User::where('email', $request->email)->first();

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => 'OTP verified successfully',
            'data' => [
                'active' => $isVerifiedOTP,
            ],
        ]);
    }

}
