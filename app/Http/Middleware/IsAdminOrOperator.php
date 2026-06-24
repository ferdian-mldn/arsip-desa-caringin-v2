<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdminOrOperator
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan Admin dan Operator untuk mengakses route.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role->nama_peran;
            if (!in_array($role, ['Admin', 'Operator'])) {
                abort(403, 'AKSES DITOLAK: Halaman ini khusus Admin dan Operator.');
            }
        }

        return $next($request);
    }
}
