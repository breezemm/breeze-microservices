<?php

namespace App\Common;

use App\Models\OneTimePassword;
use Carbon\Carbon;
use Illuminate\Encryption\MissingAppKeyException;
use Illuminate\Support\Facades\Log;

class OTP
{
    /**
     * @param string $identifier
     * @param OTPTypeEnum|null $type
     * @param int|null $length
     * @param Carbon|null $expireAt in seconds
     * @return string One Time Password
     */
    public function generate(string $identifier, ?OTPTypeEnum $type = null, ?int $length = 6, ?Carbon $expireAt = null): string
    {
        $type = $type ?? OTPTypeEnum::Numeric;
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

    private function generateOTP(OTPTypeEnum $type, int $length): string
    {
        return match ($type) {
            OTPTypeEnum::Numeric => $this->generateNumericOTP($length),
            OTPTypeEnum::Alphanumeric => $this->generateAlphaNumericOTP($length),
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

        if (!$secret) {
            throw new MissingAppKeyException();
        }

        $time = floor(time());
        $binaryTime = pack('N*', 0) . pack('N*', $time);
        $hash = hash_hmac('sha1', $binaryTime, $secret, true);
        $offset = ord(substr($hash, -1)) & 0x0F;

        return (string)(
                ((ord($hash[$offset + 0]) & 0x7F) << 24) |
                ((ord($hash[$offset + 1]) & 0xFF) << 16) |
                ((ord($hash[$offset + 2]) & 0xFF) << 8) |
                (ord($hash[$offset + 3]) & 0xFF)
            ) % pow(10, $length);
    }
}
