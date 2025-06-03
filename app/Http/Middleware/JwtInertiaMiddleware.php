<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Inertia\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtInertiaMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        try {
            $tokenCookie = $request->cookie('auth');

            if (!$tokenCookie) {
                throw new Exception("Unauthorized");
            }

            if ($tokenCookie) {
                JWTAuth::setToken($tokenCookie)->authenticate();
                return $next($request);
            }
        
            return $next($request);

        } catch (Exception $e) {
            // return response()->json([$e->getMessage()]);
            return redirect("/");
        }
    }
}
