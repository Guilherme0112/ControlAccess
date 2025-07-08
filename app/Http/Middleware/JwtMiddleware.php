<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Foundation\Configuration\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        try {
            $tokenCookie = $request->cookie('auth');

            if (!$tokenCookie) {
                throw new Exception("Unauthorized");
            }

            JWTAuth::setToken($tokenCookie)->authenticate();
            return $next($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

}
