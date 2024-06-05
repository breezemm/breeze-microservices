<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Mail\EmailVerified;
use App\Packages\OTP\OTP;
use App\Packages\OTP\OTPType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ResendOneTimePasswordController extends Controller
{
    /**
     * Resend OTP code
     *
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $otpCode = app(OTP::class)->generate(identifier: $request->email, type: OTPType::Alphanumeric);

        Mail::to($request->email)->queue(new EmailVerified(code: $otpCode));

        if (app()->isLocal()) {
            return response()->json([
                'message' => 'OTP code has been sent to your email.',
                'data' => [
                    'otp' => $otpCode
                ]
            ]);
        }

        return response()->json(['message' => 'OTP code has been sent to your email.']);
    }
}
