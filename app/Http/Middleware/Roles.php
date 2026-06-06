<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! auth()->check()) {
            abort(403);
        }

        if (! in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
