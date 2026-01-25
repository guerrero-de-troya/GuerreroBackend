<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OptionalAuthSanctum
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Intentar autenticar usando Sanctum
            Auth::shouldUse('sanctum');
            Auth::user();
        } catch (\Throwable $e) {
        
        }

        return $next($request);
    }
}
