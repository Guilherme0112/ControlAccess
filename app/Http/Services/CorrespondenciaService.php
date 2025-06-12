<?php

namespace App\Http\Services;

use App\Http\Enum\Status;
use App\Models\Correspondencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class CorrespondenciaService
{

    protected EmailService $emailService;
    protected UsuarioService $usuarioService;

    public function __construct(EmailService $emailService, UsuarioService $usuarioService)
    {
        $this->emailService = $emailService;
        $this->usuarioService = $usuarioService;
    }

    public function buscarCorrespondencias()
    {
        return Correspondencia::all();
    }
    public function buscarCorrespondenciasPorSessao(string $token)
    {
        $payload = JWTAuth::setToken(
            $token
        )->getPayload()->toArray();

        $emailUsuario = $payload["email"];
        return Correspondencia::where("email_usuario", $emailUsuario)->get();
    }

    public function buscarCorrespondencia(string $idCorrespondencia)
    {
        return Correspondencia::findOrFail($idCorrespondencia);
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

        if ($request->hasFile('correspondencia')) {
            $caminho = $request->file('correspondencia')->store('correspondencias', 'public');
            $validated['correspondencia'] = $caminho;
            $validated["status"] = Status::ENVIADO;

            $token = $request->cookie("auth");
            $payload = JWTAuth::setToken($token)->getPayload()->toArray();
            
            $loginEmail = $payload["email"];
            $usuario = $this->usuarioService->buscarUsuarioPorEmail($loginEmail);

            $path = $request->file('correspondencia')->store("correspondencias", "public");
            $validated['correspondencia'] = $path;
            $correspondencia["status"] = Status::ENVIADO;
            $this->emailService->sendEmailNotificacaoAnexo($usuario);
        }

        return Correspondencia::create($validated);
    }

    public function editarCorrespondencia(Request $request, string $id): Correspondencia
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            "nome" => "sometimes|nullable|string|max:255",
            "email_usuario" => "sometimes|nullable|email|exists:usuarios,email",
            "caixa_postal" => "sometimes|nullable|string|max:255",
            "unidade" => "sometimes|nullable|string|max:255",
            "remetente" => "sometimes|nullable|string|max:255",
            "status" => "sometimes|nullable|string|in:cadastrado,notificado,aprovado,enviado",
            "data_recebimento" => "sometimes|nullable|date",
            "correspondencia" => "sometimes|file|mimes:png,jpg,jpeg|max:2048"
        ]);

        $correspondencia = Correspondencia::findOrFail($id);

        if ($request->hasFile('correspondencia')) {
            if ($correspondencia["correspondencia"]) {
                Storage::disk('public')->delete($correspondencia["correspondencia"]);
            }

            $token = $request->cookie("auth");
            $payload = JWTAuth::setToken($token)->getPayload()->toArray();
            
            $loginEmail = $payload["email"];
            $usuario = $this->usuarioService->buscarUsuarioPorEmail($loginEmail);

            $path = $request->file('correspondencia')->store("correspondencias", "public");
            $validated['correspondencia'] = $path;
            $correspondencia["status"] = Status::ENVIADO;
            $this->emailService->sendEmailNotificacaoAnexo($usuario);
        }

        $dadosParaAtualizar = collect($validated)
            ->filter(fn($valor) => !is_null($valor))
            ->all();

        $correspondencia->update($dadosParaAtualizar);

        return $correspondencia;
    }

    public function apagarCorrespondencia(string $id): void
    {
        $correspodencia = Correspondencia::findOrFail($id);
        $correspodencia->delete();
    }

}