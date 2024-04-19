<?php

namespace App\Http\Controllers;

use App\Common\OTP;
use App\Http\Requests\ValidationRequest;
use App\Jobs\SendEmailVerificationOTPCodeJob;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function __construct(
        public readonly OTP $otp,
    )
    {
    }

    public function verify(ValidationRequest $request)
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

        $response = app()->isProduction() ? [
            'message' => 'Email Verification Code resent successfully',
        ] : [
            'message' => 'Email Verification Code resent successfully',
            'otp' => $otpCode,
        ];

        return response()->json($response);
    }
}
