<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->id == 1 && Auth::user()->email_verified_at != null)
        {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->role->id > 3 && Auth::user()->email_verified_at != null && Auth::user()->deleted_at == null) {
            return $next($request);
        } else {
            // Auth::logout();
            // return redirect('/login')->with('failure', 'Please Verify your account first.');

            return redirect()->route('login')->with('success','Logged in successfully.');
        }
    }
}
