<?php

namespace App\Jobs;

use App\Mail\EmailVerificationCodeSentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationOTPCodeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $email,
        public readonly string $verificationCode,
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new EmailVerificationCodeSentMail(
                code: $this->verificationCode,
            ));
    }
}
