<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Common\OTP;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\ProfileImageRequest;
use App\Http\Requests\V1\Auth\ValidationRequest;
use App\Jobs\SendEmailVerificationOTPCodeJob;
use App\Models\VerificationCode;
use App\Support\CodeGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidationController extends Controller implements ShouldQueue
{
    public function __construct(
        public readonly OTP $otp,
    )
    {
    }

    public function validateEmail(ValidationRequest $request)
    {
        $email = $request->validated('email');

        $otpCode = $this->otp->generate(identifier: $email);

        dispatch(new SendEmailVerificationOTPCodeJob(
            email: $email,
            verificationCode: $otpCode,
        ));

        return response()->json([
            'message' => 'Email Verification Code sent successfully',
        ]);
    }


    public function validateProfileImage(ProfileImageRequest $request)
    {
        return response()->json([
            'message' => 'Profile image is valid',
        ]);
    }
}
