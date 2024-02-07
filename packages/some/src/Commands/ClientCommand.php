<?php

namespace Breeze\MongoDB\Commands;

use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Console\ClientCommand as BaseClientCommand;
use Laravel\Passport\Passport;

class ClientCommand extends BaseClientCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport-mongodb:client
            {--personal : Create a personal access token client}
            {--password : Create a password grant client}
            {--client : Create a client credentials grant client}
            {--name= : The name of the client}
            {--provider= : The name of the user provider}
            {--redirect_uri= : The URI to redirect to after authorization }
            {--user_id= : The user ID the client should be assigned to }
            {--public : Create a public client (Auth code grant type only) }';

    /**
     * Create a new personal access client.
     *
     */
    protected function createPersonalClient(ClientRepository $clients): void
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the personal access client?',
            config('app.name') . ' Personal Access Client'
        );

        $client = $clients->createPersonalAccessClient(
            null, $name, 'http://localhost'
        );

        $this->info('Personal access client created successfully.');

        $this->outputMongodbClientDetails($client);
    }

    /**
     * Create a new password grant client.
     *
     * @param \Laravel\Passport\ClientRepository $clients
     * @return void
     */
    protected function createPasswordClient(ClientRepository $clients): void
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the password grant client?',
            config('app.name') . ' Password Grant Client'
        );

        $providers = array_keys(config('auth.providers'));

        $provider = $this->option('provider') ?: $this->choice(
            'Which user provider should this client use to retrieve users?',
            $providers,
            in_array('users', $providers) ? 'users' : null
        );

        $client = $clients->createPasswordGrantClient(
            null, $name, 'http://localhost', $provider
        );

        $this->info('Password grant client created successfully.');

        $this->outputMongodbClientDetails($client);
    }

    /**
     * Output the client's ID and secret key.
     *
     * @return void
     */
    protected function outputMongodbClientDetails(Client|\Breeze\MongoDB\Passport\Client $client): void
    {
        if (Passport::$hashesClientSecrets) {
            $this->line('<comment>Here is your new client secret. This is the only time it will be shown so don\'t lose it!</comment>');
            $this->line('');
        }

        $this->line('<comment>Client ID:</comment> ' . $client->id);
        $this->line('<comment>Client secret:</comment> ' . $client->plainSecret);
    }
}
