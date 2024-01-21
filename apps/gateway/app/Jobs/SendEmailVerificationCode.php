<?php

namespace App\Jobs;

use App\Mail\EmailVerificationCodeSent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $email,
        public readonly string $verificationCode,
    ) {
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new EmailVerificationCodeSent(
            code: $this->verificationCode,
        ));
    }
}
