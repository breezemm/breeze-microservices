<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class CheckScopes
{
    /**
     * Specify the scopes for the middleware.
     *
     * @param array|string $scopes
     * @return string
     */
    public static function using(...$scopes): string
    {
        if (is_array($scopes[0])) {
            return static::class . ':' . implode(',', $scopes[0]);
        }

        return static::class . ':' . implode(',', $scopes);
    }


    /**
     * @param Request $request
     * @param Closure $next
     * @param ...$scopes
     * @return Response
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
