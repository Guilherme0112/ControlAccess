<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(Request $request): Usuario
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        $usuario = Usuario::where('email', $credentials['email'])->first();

        if (!$usuario || !Hash::check($credentials['senha'], $usuario->senha)) {
            throw ValidationException::withMessages([
                'auth' => ['As credenciais estão incorretas.'],
            ]);
        }

        return $usuario;
    }

    public function logout(): void
    {

    }
}