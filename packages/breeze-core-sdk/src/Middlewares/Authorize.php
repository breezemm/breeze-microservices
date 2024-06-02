<?php

namespace MyanmarCyberYouths\Breeze\Middlewares;

use Closure;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Facades\Breeze;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAuth = Breeze::auth()->check();

        abort_unless($isAuth, Response::HTTP_FORBIDDEN, 'Unauthorized');

        return $next($request);
    }
}
