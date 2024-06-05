<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Mail\EmailVerified;
use App\Packages\OTP\OTP;
use App\Packages\OTP\OTPType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class EmailValidationController extends Controller
{

    /**
     * Validate email or phone number
     *
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $otpCode = app(OTP::class)->generate(identifier: $request->email, type: OTPType::Alphanumeric);

        Mail::to($request->email)->queue(new EmailVerified(code: $otpCode));

        // If the app is in production, we don't want to send the OTP code
        $response = app()->isProduction()
            ? ['message' => 'Email Verification Code sent successfully',]
            : [
                'message' => 'Email Verification Code sent successfully',
                'data' => [
                    'otp_code' => $otpCode,
                ]
            ];

        return response()->json($response);
    }
}
