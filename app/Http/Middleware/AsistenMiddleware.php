<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AsistenMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dengan guard asisten
        if (!auth('asisten')->check()) {
            return redirect()->route('filament.asisten.auth.login');
        }

        // Cek apakah user memiliki role asisten
        $user = auth('asisten')->user();
        
        if ($user->role !== 'asisten') {
            auth('asisten')->logout();
            return redirect()->route('filament.asisten.auth.login')
                ->withErrors(['email' => 'Access denied. Asisten access required.']);
        }

        return $next($request);
    }
}