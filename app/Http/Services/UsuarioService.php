<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioService
{

    public function buscarUsuarios()
    {
        return Usuario::all();
    }

    public function buscarUsuarioPorEmail(string $email): Usuario
    {
        return Usuario::where("email", $email)->first();
    }


    public function salvarUsuario(Request $request): Usuario
    {
        $validated = $request->validate([
            "nome" => "required",
            "email" => "required|email",
            "senha" => "required|string|min:6",

        ]);

        return Usuario::create($validated);
    }

    public function editarUsuario(Request $request, string $id): Usuario
    {
        $validated = $request->validate([
            "nome" => "required",
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->update($validated);
        return $usuario;
    }

    public function apagarUsuario(string $id): void
    {
        $correspodencia = Usuario::findOrFail($id);
        $correspodencia->delete();
    }

}