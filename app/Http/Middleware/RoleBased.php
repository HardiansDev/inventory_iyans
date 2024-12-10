<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleBased
{
    public function handle($request, Closure $next, $role = null)
    {
        if (!Auth::check() || ($role && Auth::user()->role !== $role)) {
            return abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
