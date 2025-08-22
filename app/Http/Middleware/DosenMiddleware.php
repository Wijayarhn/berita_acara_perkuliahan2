<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('dosen')->check()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai dosen.');
    }
}