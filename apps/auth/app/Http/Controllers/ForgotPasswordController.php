<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Mail\EmailVerified;
use App\Packages\OTP\OTP;
use App\Packages\OTP\OTPType;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

    /**
     * @unauthenticated
     *
     * Forgot password
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $otpCode = app(OTP::class)->generate(identifier: $request->email, type: OTPType::Alphanumeric);

        Mail::to($request->email)->queue(new EmailVerified(code: $otpCode));

        return response()->json([
            'message' => 'OTP sent to your email',
            'data' => [
                'otp' => $otpCode,
            ],
        ]);
    }
}
