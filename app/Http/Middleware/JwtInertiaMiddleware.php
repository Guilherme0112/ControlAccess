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
            $cookieHeader = $request->header('cookie');
            $token = null;

            if (!$cookieHeader) {
                throw new Exception("Unauthorized");
            }
            
            preg_match('/auth=([^;]+)/', $cookieHeader, $matches);

            if (isset($matches[1])) {
                $token = urldecode($matches[1]);
            }

            if (!$token) {
                throw new Exception("Unauthorized");
            }

            JWTAuth::setToken($token);

            return $next($request);

        } catch (Exception $e) {
            // return response()->json([$e->getMessage()]);
            return redirect("/");
        }
    }
}
