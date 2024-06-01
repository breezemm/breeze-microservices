<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use JsonException;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Requests\OAuthIntrospectionRequest;
use MyanmarCyberYouths\Breeze\Facades\Breeze;
use Symfony\Component\HttpFoundation\Response;

class SSOAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = Breeze::auth()->send(new OAuthIntrospectionRequest($request->bearerToken()));

            if (!$response->json('active')) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }


            return $next($request);
        } catch (Exception|JsonException) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

    }
}
