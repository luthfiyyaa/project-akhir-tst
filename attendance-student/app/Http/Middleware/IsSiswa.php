<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsSiswa
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('murid')->user();

        if ($user && $user->role === 'siswa') {
            return $next($request);
        }

        abort(403, 'Akses tidak diizinkan.');
    }
}

