<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdminInertia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                throw new Exception("Unauthorized");
            }
            return $next($request);
        } catch (Exception $e) {
            return redirect("/user");
        }
    }
}
