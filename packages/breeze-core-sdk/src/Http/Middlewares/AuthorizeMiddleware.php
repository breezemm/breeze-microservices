<?php

namespace MyanmarCyberYouths\Breeze\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Facades\Breeze;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAuth = Breeze::auth()->check();

        abort_unless($isAuth, 401, 'Unauthorized');

        return $next($request);
    }
}
