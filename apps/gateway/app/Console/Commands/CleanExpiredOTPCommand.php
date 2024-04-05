<?php

namespace App\Console\Commands;

use App\Models\OneTimePassword;
use Illuminate\Console\Command;

class CleanExpiredOTPCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧹 Cleaning expired OTPs.');

        try {
            OneTimePassword::where('expires_at', '<', now())
                ->orWhere('status', 'verified')
                ->delete();
        } catch (\Exception $e) {
            $this->error('Failed to clean expired OTPs.');
            $this->error($e->getMessage());

            return 1;
        }

        return 0;
    }
}
