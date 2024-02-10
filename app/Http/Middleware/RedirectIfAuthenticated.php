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
     * @param  string|null  $guard
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->role->id == 1 && Auth::user()->email_verified_at != null) {
            return redirect()->route('admin.dashboard')->with('success','Logged in successfully.');
        } elseif(Auth::guard($guard)->check() && Auth::user()->role->id == 2 && Auth::user()->email_verified_at != null) {
            return redirect()->route('seller.dashboard')->with('success','Logged in successfully.');
        } elseif(Auth::guard($guard)->check() && Auth::user()->role->id == 3 && Auth::user()->email_verified_at != null && Auth::user()->deleted_at == null) {
            return redirect()->route('customer.dashboard')->with('success','Logged in successfully.');
        } elseif(Auth::guard($guard)->check() && Auth::user()->role->id > 3 && Auth::user()->email_verified_at != null && Auth::user()->deleted_at == null) {
            return redirect()->route('admin.dashboard')->with('success','Logged in successfully.');
        } else {
            return $next($request);
        }
    }
}
