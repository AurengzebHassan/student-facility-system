<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the 'id' session exists
        if ($request->session()->has('id')) {
            // If 'id' session exists, allow access
            return $next($request);
        }

        // If 'id' session does not exist, redirect to login page
        return redirect()->route('login');
    }
}
