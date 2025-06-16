<?php

namespace App\Http\Middleware;

use Closure;

class GoldMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->level() < 4) {
            return redirect(route('payment.subscribe'));
        }
        return $next($request);
    }
}
