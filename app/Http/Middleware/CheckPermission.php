<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $permission): Response
    {
        // Check if the authenticated user has the required permission
        if (auth()->check() && auth()->user()->hasPermissions($permission)) {
            return $next($request);
        }

        abort(403);
    }
}
