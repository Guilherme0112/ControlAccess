<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{

    public function login(Request $request, AuthService $authService): JsonResponse
    {

        try {
            $usuario = $authService->login($request);

            $token = JWTAuth::fromUser($usuario);

            return response()->json([
                "usuario" => $usuario,
                "token" => $token
            ])->cookie(
                'auth',
                $token,
                60 * 4,
                '/',
                null,
                false,
                true,
                false,
                'Strict'
            );
        } catch (ValidationException $e) {
            return response()->json([
                "errors" => $e->errors()
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                "errors" => $e->getMessage()
            ], 500);
        }
    }



    public function logout(): JsonResponse
    {
        return response()
            ->json(['message' => 'Logout realizado com sucesso.'])
            ->withoutCookie('auth');
    }

}
