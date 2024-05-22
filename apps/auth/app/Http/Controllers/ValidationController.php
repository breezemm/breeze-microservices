<?php

namespace App\Http\Controllers;

use App\Common\OTP;
use App\Common\OTPType;
use App\Http\Requests\ValidationRequest;
use App\Jobs\SendEmailVerificationOTPCodeJob;
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
     * @param ValidationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateEmail(ValidationRequest $request)
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
