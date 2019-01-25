<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (cidr_match($request->ip(), config('ip.allow'))) {
            if (Auth::guard('api')->check()) {
                return $next($request);
            }
        }
        return redirect()->route('login');
    }
}
