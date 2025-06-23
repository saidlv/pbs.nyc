<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        }
        
        $response = $next($request);
        
        // Additional session cookie fixes for Railway
        if (env('RAILWAY_ENVIRONMENT') || env('APP_ENV') === 'production') {
            // Ensure session cookies work with Railway's setup
            if ($response instanceof \Illuminate\Http\Response) {
                $sessionCookieName = config('session.cookie');
                
                // Force session cookie settings for Railway
                if (isset($_COOKIE[$sessionCookieName])) {
                    setcookie(
                        $sessionCookieName,
                        $_COOKIE[$sessionCookieName],
                        [
                            'expires' => time() + (config('session.lifetime') * 60),
                            'path' => '/',
                            'domain' => '',
                            'secure' => true,
                            'httponly' => true,
                            'samesite' => 'Lax'
                        ]
                    );
                }
            }
        }
        
        return $response;
    }
}
