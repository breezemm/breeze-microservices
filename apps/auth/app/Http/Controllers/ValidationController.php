<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Jobs\SendEmailVerificationOTPCodeJob;
use App\Packages\OTP\OTP;
use App\Packages\OTP\OTPType;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidationController extends Controller implements ShouldQueue
{
    public function __construct(
        public readonly OTP $otp,
    )
    {
    }

    /**
     * Validate email or phone number
     *
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateEmail(EmailVerificationRequest $request)
    {
        $email = $request->validated('email');

        $otpCode = $this->otp->generate(identifier: $email, type: OTPType::Alphanumeric);

        dispatch(
            new SendEmailVerificationOTPCodeJob(
                email: $email,
                verificationCode: $otpCode,
            )
        );

        $response = app()->isProduction()
            ? ['message' => 'Email Verification Code sent successfully',]
            : [
                'message' => 'Email Verification Code sent successfully',
                [
                    'data' => [
                        'otp' => $otpCode,
                    ]
                ],
            ];

        return response()->json($response);
    }
}
