<?php

namespace Breeze\MongoDB\Commands;

use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Console\InstallCommand as BaseInstallCommand;
use Laravel\Passport\Passport;

class InstallCommand extends BaseInstallCommand
{
    protected  $signature = 'passport-mongodb:install
                            {--uuids : Use UUIDs for all client IDs}
                            {--force : Overwrite keys they already exist}
                            {--length=4096 : The length of the private key}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = in_array('users', array_keys(config('auth.providers'))) ? 'users' : null;

        $this->call('passport:keys', ['--force' => $this->option('force'), '--length' => $this->option('length')]);
        $this->call('mongodb-passport:client', ['--personal' => true, '--name' => config('app.name') . ' Personal Access Client']);
        $this->call('mongodb-passport:client', ['--password' => true, '--name' => config('app.name') . ' Password Grant Client', '--provider' => $provider]);
    }
}
