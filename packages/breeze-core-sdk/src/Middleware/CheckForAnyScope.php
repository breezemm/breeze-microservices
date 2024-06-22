<?php

namespace MyanmarCyberYouths\Breeze\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForAnyScope
{
    /**
     * @throws AuthenticationException
     * @throws Exception
     */
    public function handle(Request $request, Closure $next, ...$scopes): Response
    {
        if (! $request->user()) {
            throw new AuthenticationException;
        }

        if ($request->user()->tokenCan($scopes)) {
            return $next($request);
        }

        throw new Exception('User does not have the required scopes.', 403);
    }
}
