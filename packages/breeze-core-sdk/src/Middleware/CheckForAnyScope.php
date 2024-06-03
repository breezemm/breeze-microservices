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
     * Specify the scopes for the middleware.
     *
     * @param  array|string  $scopes
     */
    public static function using(...$scopes): string
    {
        if (is_array($scopes[0])) {
            return static::class . ':' . implode(',', $scopes[0]);
        }

        return static::class . ':' . implode(',', $scopes);
    }

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
