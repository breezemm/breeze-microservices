<?php

namespace App\Http\Controllers;

use App\Common\OTP;
use App\Http\Requests\V1\Auth\ValidationRequest;
use App\Jobs\SendEmailVerificationOTPCodeJob;
use Illuminate\Http\JsonResponse;

class OTPController extends Controller
{
    public function __construct(
        public readonly OTP $otp,
    )
    {
    }

    public function verify(ValidationRequest $request): JsonResponse
    {
        $isVerifiedOTP = $this->otp->verify(
            identifier: $request->validated('email'),
            otp: $request->validated('code'),
        );

        abort_if(!$isVerifiedOTP, 422, 'Invalid OTP code');

        return response()->json([
            'message' => 'OTP verified successfully',
        ]);
    }

    public function resend(ValidationRequest $request)
    {
        $email = $request->validated('email');

        $otpCode = $this->otp->generate(identifier: $email);

        dispatch(new SendEmailVerificationOTPCodeJob(
            email: $email,
            verificationCode: $otpCode,
        ));

        return response()->json([
            'message' => 'Email Verification Code resent successfully',
        ]);
    }
}
