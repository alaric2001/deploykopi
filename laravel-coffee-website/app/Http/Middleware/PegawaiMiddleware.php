<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PegawaiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Assuming your User model has a 'role' attribute
        if (Auth::check() && (Auth::user()->role == 'pegawai' || Auth::user()->role == 'admin')) {
            return $next($request);
        }
        abort(401);
        // return redirect('/'); // Redirect to home or any other page if not authorized
    }
}
