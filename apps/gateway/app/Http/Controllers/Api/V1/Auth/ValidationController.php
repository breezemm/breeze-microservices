<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\ProfileImageRequest;
use App\Http\Requests\V1\Auth\ValidationRequest;
use App\Jobs\SendEmailVerificationCode;
use App\Models\VerificationCode;
use App\Support\CodeGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidationController extends Controller implements ShouldQueue
{
    public function validateEmail(ValidationRequest $request)
    {
        if (! $request->validated()) {
            abort(422, 'Email (or) Phone Number is not valid');
        }

        $verificationCode = CodeGenerator::generate();

        VerificationCode::create(
            [
                'email' => $request->email,
                'code' => $verificationCode,
                'type' => $request->type,
                'expires_at' => now()->addMinutes(2),
            ]);

        dispatch(new SendEmailVerificationCode(
            email: $request->email,
            verificationCode: $verificationCode,
        ));

        return response()->json([
            'message' => 'Email Verification Code sent successfully',
        ]);
    }

    public function resendVerificationCode(ValidationRequest $request)
    {

        if (! $request->validated()) {
            abort(422, 'Email (or) Phone Number is not valid');
        }

        $verificationCodeModel = VerificationCode::where('email', $request->email)->first();

        if (! $verificationCodeModel?->expires_at->addMinutes(2)->isPast()) {
            abort(422, 'Verification code is not expired yet');
        }

        $verificationCode = CodeGenerator::generate();

        $verificationCodeModel->update([
            'code' => $verificationCode,
            'expires_at' => now()->addMinutes(2),
        ]);

        dispatch(new SendEmailVerificationCode(
            email: $request->email,
            verificationCode: $verificationCode,
        ));

        return response()->json([
            'message' => 'Verification code sent successfully',
        ]);
    }

    public function validateProfileImage(ProfileImageRequest $request)
    {
        return response()->json([
            'message' => 'Profile image is valid',
        ]);
    }
}
