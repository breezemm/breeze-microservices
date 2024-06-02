<?php

namespace App\Packages\OTP;

use App\Models\OneTimePassword;
use Carbon\Carbon;
use Illuminate\Encryption\MissingAppKeyException;

class OTP
{
    /**
     * @param  Carbon|null  $expireAt  in seconds
     * @return string One Time Password
     */
    public function generate(string $identifier, ?OTPType $type = null, ?int $length = 6, ?Carbon $expireAt = null): string
    {
        $type = $type ?? OTPType::Numeric;
        $otp = $this->generateOTP($type, $length);

        OneTimePassword::create([
            'identifier' => $identifier,
            'otp' => $otp,
            'expires_at' => $expireAt ?? now()->addMinutes(2),
        ]);

        return $otp;
    }

    public function verify(string $identifier, string $otp): bool
    {
        $otpRecord = OneTimePassword::where('identifier', $identifier)
            ->orWhere('otp', $otp)
            ->where('expires_at', '>=', now())
            ->latest();

        return $otpRecord->exists();
    }

    private function generateOTP(OTPType $type, int $length): string
    {
        return match ($type) {
            OTPType::Numeric => $this->generateNumericOTP($length),
            OTPType::Alphanumeric => $this->generateAlphaNumericOTP($length),
            default => throw new \InvalidArgumentException('Invalid OTP type.'),
        };
    }

    private function generateAlphaNumericOTP(int $length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle($characters), 0, $length);
    }

    private function generateNumericOTP(int $length = 6): string
    {
        $secret = config('app.key');

        if (! $secret) {
            throw new MissingAppKeyException();
        }

        $time = now()->timestamp * 30;
        $binaryTime = pack('N*', 0) . pack('N*', $time);
        $hash = hash_hmac('sha1', $binaryTime, $secret, true);
        $offset = ord(substr($hash, -1)) & 0x0F;

        return (string) (
            ((ord($hash[$offset + 0]) & 0x7F) << 24) |
            ((ord($hash[$offset + 1]) & 0xFF) << 16) |
            ((ord($hash[$offset + 2]) & 0xFF) << 8) |
            (ord($hash[$offset + 3]) & 0xFF)
        ) % pow(10, $length);
    }
}
