<?php

namespace App\Http\Integrations\Wallet;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AcceptsJson;

class WalletConnector extends Connector
{
    use AcceptsJson;
    use AuthorizationCodeGrant;

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
}
