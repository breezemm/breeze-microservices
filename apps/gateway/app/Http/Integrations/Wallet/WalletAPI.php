<?php

namespace App\Http\Integrations\Wallet;

use App\Http\Integrations\Wallet\Resource\WalletsResource;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AcceptsJson;

class WalletAPI extends Connector
{
    use AcceptsJson;
    use AuthorizationCodeGrant;

    public ?int $tries = 3;

    public ?int $retryInterval = 500;

    public ?bool $useExponentialBackoff = true;

    /**
     * The Base URL of the API.
     */
    public function resolveBaseUrl(): string
    {
        return 'http://wallets.test/api/v1';
    }

    /**
     * The OAuth2 configuration
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId('')
            ->setClientSecret('')
            ->setRedirectUri('')
            ->setDefaultScopes([])
            ->setAuthorizeEndpoint('authorize')
            ->setTokenEndpoint('token')
            ->setUserEndpoint('user');
    }

    public function wallets(): WalletsResource
    {
        return new WalletsResource($this);
    }
}
