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
            $cookieHeader = $request->header("cookie");
            $token = null;

            if ($cookieHeader) {
                $cookies = explode(';', $cookieHeader);
                foreach ($cookies as $cookie) {
                    $cookie = trim($cookie);
                    if (str_starts_with($cookie, 'auth=')) {
                        $token = substr($cookie, strlen('auth='));
                        break;
                    }
                }
            }

            JWTAuth::setToken($token)->authenticate();
            return $next($request);

        } catch (Exception $e) {
            // return response()->json([$e->getMessage()]);
            return redirect("/");
        }
    }
}
