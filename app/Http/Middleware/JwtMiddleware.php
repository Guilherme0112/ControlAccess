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
            $cookieHeader = $request->header('cookie');
            $token = null;
            if ($cookieHeader) {
                preg_match('/auth=([^;]+)/', $cookieHeader, $matches);
                if (isset($matches[1])) {
                    $token = urldecode($matches[1]);
                }
            }

            if (!$token) {
                return response()->json(['error' => 'Token ausente'], 401);
            }

            return $next($request);
        } catch (Exception $e) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }
    }

}
