<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckScopeMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
//        if (!$request->user()->tokenCan($role)) {
//            return response()->json([
//                'message' => 'Unauthorized'
//            ], 403);
//        }


        count(array_intersect($roles, $request->user()->getScopes())) == 0 ? abort(403, 'Unauthorized') : null;

        return $next($request);
    }
}
