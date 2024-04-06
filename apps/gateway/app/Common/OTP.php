<?php

namespace App\Common;

use App\Models\OneTimePassword;
use Illuminate\Encryption\MissingAppKeyException;

class OTP
{
    /**
     * @param int|null $expireAt in seconds
     * @return string One Time Password
     */
    public function generate(string $identifier, ?OTPTypeEnum $type = null, ?int $length = 6, ?int $expireAt = 0): string
    {
        $type = $type ?? OTPTypeEnum::Numeric;

        OneTimePassword::create([
            'identifier' => $identifier,
            'otp' => $this->generateOTP($type, $length),
            'expires_at' => now()->addSeconds($expireAt),
        ]);

        return $this->generateOTP($type, $length);
    }

    public function verify(string $identifier, string $otp): bool
    {
        $otpRecord = OneTimePassword::where('identifier', $identifier)
            ->where('otp', $otp)
            ->orWhere('status', 'pending')
            ->orWhere('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return false;
        }


        return true;
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

        $time = floor(microtime(time()));
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
