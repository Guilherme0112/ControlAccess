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
            $token = $request->cookie('auth');
            if (!$token)
                throw new Exception('Token ausente');

            JWTAuth::setToken($token)->authenticate();

            return $next($request);
        } catch (Exception $e) {
            return redirect("/");
        }
    }
}
