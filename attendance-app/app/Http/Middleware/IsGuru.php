<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsGuru
{
    public function handle(Request $request, Closure $next)
{
    \Log::info('Masuk middleware IsGuru');
    if (Auth::check() && Auth::user()->role === 'guru') {
        \Log::info('Role: guru - Lolos');
        return $next($request);
    }

    \Log::info('Role bukan guru atau tidak login');
    abort(403, 'Akses tidak diizinkan.');
}

}
