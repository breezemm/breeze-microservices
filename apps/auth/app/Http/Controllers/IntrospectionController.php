<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntrospectRequest;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\File;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Throwable;

class IntrospectController extends Controller implements HasMiddleware
{

    public function __construct(
        public AccessTokenRepository $accessTokenRepository,
        public ClientRepository      $clientRepository,
    )
    {
    }

    public static function middleware(): array
    {
        return [
            'auth:api',
        ];
    }


    /**
     * @param IntrospectRequest $request
     * @return JsonResponse
     * @link https://www.oauth.com/oauth2-servers/token-introspection-endpoint/
     * @example
     * ```curl
     * http://localhost:8000/api/oauth2/introspect?token=eyJ0eXA&token_type_hint=access_token
     * ```
     */
    public function __invoke(IntrospectRequest $request)
    {
        try {
            $token = $request->validated('token');

            $claims = $this->getClaims($token);

            throw_if($this->accessTokenRepository->isAccessTokenRevoked($claims['jti']));
            throw_if($this->clientRepository->revoked($claims['aud']));

            return response()->json([
                'active' => true,
                ...$claims,
            ]);

        } catch (Exception|Throwable $exception) {
            return response()->json([
                'active' => false,
            ]);
        }
    }


    /*
     * @return array JWT Claims
     * */
    public
    function getClaims(?string $token): array
    {
        $publicKey = File::get(Passport::keyPath('oauth-public.key'));

        return (array)JWT::decode($token, new Key($publicKey, 'RS256'));
    }


}
