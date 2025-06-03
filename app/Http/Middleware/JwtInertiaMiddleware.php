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
            $tokenHeader = $request->header('cookie');

            if (!$tokenCookie && !$tokenHeader) {
                throw new Exception("Unauthorized");
            }

            if ($tokenHeader) {
                preg_match('/auth=([^;]+)/', $tokenHeader, $matches);
                if (!isset($matches[1])) {
                    throw new Exception("Unauthorized");
                }

                $token = urldecode($matches[1]);
                JWTAuth::setToken($token)->authenticate();
            }
            

            if ($tokenCookie) {
                JWTAuth::setToken($tokenCookie)->authenticate();
            }

            return $next($request);

        } catch (Exception $e) {
            // return response()->json([$e->getMessage()]);
            return redirect("/");
        }
    }
}
