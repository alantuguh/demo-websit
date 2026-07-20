<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dengan guard admin
        if (!auth('admin')->check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        // Cek apakah user memiliki role admin
        $user = auth('admin')->user();
        
        if ($user->role !== 'admin') {
            auth('admin')->logout();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Access denied. Admin access required.']);
        }

        return $next($request);
    }
}