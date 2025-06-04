<?php

namespace App\Http\Services;

use App\Http\Enum\Status;
use App\Models\Correspondencia;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CorrespondenciaService
{

    public function buscarCorrespondencias(Request $request)
    {
        $payload = JWTAuth::setToken(
            $request->cookie("auth")
        )->getPayload()->toArray();

        $emailUsuario = $payload["email"];
        return Correspondencia::where("email_usuario", $emailUsuario);
    }

    public function buscarCorrespondencia(string $idCorrespondencia)
    {
        return Correspondencia::findOrFail($idCorrespondencia);
    }

    public function buscarCorrespondenciasPorEmail(string $emailUsuario)
    {
        return Correspondencia::where("email_usuario", $emailUsuario);
    }

    public function alterarStatusCorrespondencia(Status $novoStatus, string $idCorrespondencia): Correspondencia
    {
        $correspondencia = Correspondencia::findOrFail($idCorrespondencia);
        $correspondencia["status"] = $novoStatus;
        $correspondencia->update();

        return $correspondencia;
    }

    public function salvarCorrespondencia(Request $request): Correspondencia
    {
        $validated = $request->validate([
            "nome" => "required",
            "email_usuario" => "required|email|exists:usuarios,email",
            "caixa_postal" => "required",
            "unidade" => "required",
            "remetente" => "required",
            "status" => "required|in:cadastrado,entregue,aprovado,devolvido",
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
            "remetente" => "required",
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