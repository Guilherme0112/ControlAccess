<?php

namespace App\Http\Controllers;

use App\Http\Enum\Status;
use App\Http\Services\CorrespondenciaService;
use App\Http\Services\EmailService;
use App\Http\Services\UsuarioService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CorrespondenciaController extends Controller
{
    
    public function index(CorrespondenciaService $correspondenciaService): JsonResponse
    {
        return response()->json($correspondenciaService->buscarCorrespondencias());
    }
 
    public function show(CorrespondenciaService $correspondenciaService, Request $request): JsonResponse
    {
        $token = $request->cookie("auth");
        return response()->json($correspondenciaService->buscarCorrespondenciasPorSessao($token));
    }

    public function store(Request $request, CorrespondenciaService $correspondenciaService): JsonResponse
    {
        try {
            $correspondenciaAtualizada = $correspondenciaService->salvarCorrespondencia($request);
            return response()->json($correspondenciaAtualizada);

        } catch (ValidationException $e) {
            return response()->json([
                "errors" => $e->errors()
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, CorrespondenciaService $correspondenciaService, string $id): JsonResponse
    {
        try {
            $correspondenciaAtualizada = $correspondenciaService->editarCorrespondencia($request, $id);
            return response()->json($correspondenciaAtualizada);
        } catch (ValidationException $e) {
            return response()->json([
                "errors" => $e->errors()
            ], 400);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 500);
        }
    }


    public function notificarRecebimento(EmailService $emailService, UsuarioService $usuarioService, CorrespondenciaService $correspondenciaService, Request $request): JsonResponse
    {
        try {
            $email = $request->input("email");
            $idCorrespondencia = $request->input("idCorrespondencia");
            $usuario = $usuarioService->buscarUsuarioPorEmail($email);

            $emailService->sendEmailNotificacao($usuario);

            $correspondenciaService->alterarStatusCorrespondencia(Status::NOTIFICADO, $idCorrespondencia);

            return response()->json(["success" => "Usuário notificado com sucesso"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function aprovarAbertura(UsuarioService $usuarioService, CorrespondenciaService $correspondenciaService, Request $request): JsonResponse
    {
        try {

            $token = $request->cookie("auth");
            $idCorrespondencia = $request->input("idCorrespondencia");
       
            $payload = JWTAuth::setToken($token)->getPayload()->toArray();
            
            $loginEmail = $payload["email"];
            $usuarioService->buscarUsuarioPorEmail($loginEmail);

            $correspondenciaService->alterarStatusCorrespondencia(Status::APROVADO, $idCorrespondencia);

            return response()->json(["success" => "Usuário notificado com sucesso"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function destroy(string $idCorrespondencia, CorrespondenciaService $correspondenciaService): JsonResponse
    {
        $correspondenciaService->apagarCorrespondencia($idCorrespondencia);
        return response()->json([
            "success" => "Correspondência deletada com sucesso"
        ], 200);
    }
}
