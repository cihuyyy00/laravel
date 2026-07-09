<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // cek user udh login/blm & cek apakah rolenya ada di dlm daftar yg diizinin
        if (!$request->user() || !in_array($request->user()->role, $roles)) {

        // klo g cocok tolak
            return response()->json([
                'status'    => 'error',
                'message'   => 'Akses ditolak! Anda tidak memiliki izin untuk masuk'
            ], 403);
        }

        return $next($request);
    }
}
