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
            $token = $request->cookie('auth');
            if (!$token) throw new Exception('Token ausente');

            JWTAuth::setToken($token)->authenticate();
        } catch (Exception $e) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        return $next($request);
    }
}
