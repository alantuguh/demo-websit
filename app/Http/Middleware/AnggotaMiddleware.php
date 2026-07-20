<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnggotaMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dengan guard anggota
        if (!auth('anggota')->check()) {
            return redirect()->route('filament.anggota.auth.login');
        }

        // Cek apakah user memiliki role anggota
        $user = auth('anggota')->user();
        
        if ($user->role !== 'anggota') {
            auth('anggota')->logout();
            return redirect()->route('filament.anggota.auth.login')
                ->withErrors(['email' => 'Access denied. Anggota access required.']);
        }

        return $next($request);
    }
}