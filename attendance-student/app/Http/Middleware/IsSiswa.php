<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsSiswa
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('murid')->check()) {
            return $next($request);
        }

        abort(403, 'Akses tidak diizinkan.');
    }

}

