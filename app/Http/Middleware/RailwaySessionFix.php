<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RailwaySessionFix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Force HTTPS detection for Railway environment
        if (env('RAILWAY_ENVIRONMENT') || env('APP_ENV') === 'production') {
            // Force the request to be treated as secure
            $request->server->set('HTTPS', 'on');
            $request->server->set('SERVER_PORT', 443);
            $request->server->set('REQUEST_SCHEME', 'https');
            
            // Set the forwarded proto header if not already set
            if (!$request->header('X-Forwarded-Proto')) {
                $request->headers->set('X-Forwarded-Proto', 'https');
            }
            
            // Force Laravel to recognize this as a secure request
            $request->server->set('HTTP_X_FORWARDED_PROTO', 'https');
            $request->server->set('HTTP_X_FORWARDED_PORT', '443');
            
            // Debug logging for Railway
            Log::info('Railway Session Fix - Request Info', [
                'url' => $request->url(),
                'is_secure' => $request->isSecure(),
                'headers' => $request->headers->all(),
                'session_id' => session()->getId(),
                'auth_check' => auth()->check(),
            ]);
        }
        
        return $next($request);
    }
}
