<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Laravel\Passport\Passport;

class IntrospectController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->bearerToken();
        $tokenTypeHint = $request->input('token_type_hint');

        if (!$tokenTypeHint == 'access_token') {
            return response()->json([
                'active' => false,
            ]);
        }

        $claims = $this->introspectAccessToken($token);

        return [
            'active' => true,
            ...$claims,
        ];
    }


    /*
     * @return array
     * @ref https://www.oauth.com/oauth2-servers/token-introspection-endpoint
     * */
    private function introspectAccessToken(?string $token): array
    {
        $publicKey = File::get(Passport::keyPath('oauth-public.key'));

        return (array)JWT::decode($token, new Key($publicKey, 'RS256'));
    }
}
