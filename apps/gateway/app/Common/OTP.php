<?php

namespace App\Common;

use App\Models\OneTimePassword;
use Illuminate\Encryption\MissingAppKeyException;

class OTP
{
    public function generate(string $identifier, string $type, int $length): void
    {
        OneTimePassword::create([
            'identifier' => $identifier,
            'otp' => $this->generateOTP($type, $length),
            'status' => 'pending',
            'expires_at' => now()->addMinute(),
        ]);

    }

    /**
     * @param  string  $type  <alphanumeric|numeric>
     */
    public function generateOTP(string $type, int $length = 6): string
    {

        return match ($type) {
            'numeric' => $this->generateNumericOTP($length),
            'alphanumeric' => $this->generateAlphaNumericOTP($length),
            default => throw new \InvalidArgumentException('Invalid OTP type.'),
        };
    }

    private function generateAlphaNumericOTP(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle($characters), 0, $length);
    }

    private function generateNumericOTP(int $length): int
    {
        $secret = config('app.key');

        if (! $secret) {
            throw new MissingAppKeyException();
        }

        $time = floor(time() / 30);
        $binaryTime = pack('N*', 0).pack('N*', $time);
        $hash = hash_hmac('sha1', $binaryTime, $secret, true);
        $offset = ord(substr($hash, -1)) & 0x0F;

        return (
            ((ord($hash[$offset + 0]) & 0x7F) << 24) |
            ((ord($hash[$offset + 1]) & 0xFF) << 16) |
            ((ord($hash[$offset + 2]) & 0xFF) << 8) |
            (ord($hash[$offset + 3]) & 0xFF)
        ) % pow(10, $length);
    }
}
