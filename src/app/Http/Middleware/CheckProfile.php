<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/welcome');
        }
        
        if (!Auth::user()->cin) {
            return redirect()->route('complete-profile');
        }

        if (!Auth::user()->email_verified_at) {
            return redirect()->route('verifier-profile');
        }

        return $next($request);
    }
}
