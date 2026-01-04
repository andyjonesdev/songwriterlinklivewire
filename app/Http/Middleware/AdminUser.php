<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only allow user with ID = 1
        if (auth()->check() && auth()->id() === 1) {
            return $next($request);
        }

        // Otherwise deny access
        abort(403, 'Unauthorized.');
    }
}
