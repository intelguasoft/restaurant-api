<?php

namespace IntelGUA\FoodPoint\Http\Middleware;

use Closure;

class JWT
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
        JWTAuth::parseToken()->authenticate();

        return $next($request);
    }
}
