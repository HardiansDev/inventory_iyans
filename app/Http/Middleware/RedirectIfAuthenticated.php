<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect berdasarkan peran pengguna
            switch ($user->role) {
                case 'admin_gudang':
                    return redirect()->route('product.index');
                case 'kasir':
                    return redirect()->route('sales.index');
                case 'superadmin':
                case 'manager':
                    return redirect()->route('dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Peran tidak dikenali.');
            }
        }

        return $next($request);
    }
}
