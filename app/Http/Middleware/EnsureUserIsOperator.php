<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOperator
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isOperator()) {
            abort(403, 'Akses ditolak. Hanya operator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
