<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Connectors\Auth\Requests\OAuthIntrospectionRequest;
use MyanmarCyberYouths\Breeze\Facades\Breeze;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeMiddleware
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

            abort_unless($response->json('active'), 401);

            return $next($request);
        } catch (Exception) {
            abort(401);
        }
    }
}
