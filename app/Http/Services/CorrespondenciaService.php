<?php

namespace App\Http\Services;

use App\Models\Correspondencia;
use Illuminate\Http\Request;

class CorrespondenciaService
{

    public function buscarCorrespondencias()
    {
        return Correspondencia::all();
    }

    public function buscarCorrespondencia(string $id)
    {
        return Correspondencia::findOrFail($id);
    }

    public function buscarCorrespondenciasPorUsuario()
    {

    }

    public function salvarCorrespondencia(Request $request): Correspondencia
    {
        $validated = $request->validate([
            "nome" => "required",
            "email_usuario" => "required|email|exists:usuarios,email",
            "caixa_postal" => "required",
            "unidade" => "required",
            "status" => "required",
            "data_recebimento" => "required|date",
            "correspondencia" => "nullable|file|mimes:png,jpg,jpeg|max:2048"
        ]);

        return Correspondencia::create($validated);
    }

    public function editarCorrespondencia(Request $request, string $id): Correspondencia
    {
        $validated = $request->validate([
            "nome" => "required",
            "email_usuario" => "required|email|exists:usuarios,email",
            "caixa_postal" => "required",
            "unidade" => "required",
            "status" => "required",
            "data_recebimento" => "required|date",
            "correspondencia" => "nullable|file|mimes:png,jpg,jpeg|max:2048"
        ]);

        $correspondencia = Correspondencia::findOrFail($id);
        $correspondencia->update($validated);
        return $correspondencia;
    }

    public function apagarCorrespondencia(string $id): void
    {
        $correspodencia = Correspondencia::findOrFail($id);
        $correspodencia->delete();
    }

}