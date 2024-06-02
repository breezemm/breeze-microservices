<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerificationRequest;
use App\Mail\EmailVerified;
use App\Models\User;
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
        $user = User::where('email', $request->email)->first();

        $otpCode = app(OTP::class)->generate(identifier: $request->email, type: OTPType::Alphanumeric);

        Mail::to($request->email)->queue(new EmailVerified(code: $otpCode));

        $response = app()->isProduction() ? [
            'message' => 'Email Verification Code resent successfully',
        ] : [
            'message' => 'Email Verification Code resent successfully',
            'otp' => $otpCode,
        ];

        return response()->json($response);
    }
}
