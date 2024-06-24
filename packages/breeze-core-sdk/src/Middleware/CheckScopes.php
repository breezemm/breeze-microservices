<?php

namespace MyanmarCyberYouths\Breeze\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Aws\Acm\Exception;

class CheckScopes
{
    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next, ...$scopes): Response
    {
        if (!$request->user()) {
            throw new AuthenticationException;
        }

        if (!$request->user()->tokenCan($scopes)) {
            throw new Exception('User does not have the required scopes.', 403);
        }

        return $next($request);
    }
}
