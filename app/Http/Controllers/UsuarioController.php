<?php

namespace App\Http\Controllers;

use App\Http\Services\UsuarioService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    public function index(UsuarioService $usuarioService): JsonResponse
    {
        return response()->json($usuarioService->buscarUsuarios());
    }


    public function store(Request $request, UsuarioService $usuarioService): JsonResponse
    {
        try {
            $correspondenciaAtualizada = $usuarioService->salvarUsuario($request);
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

    public function update(Request $request, UsuarioService $usuarioService, string $id): JsonResponse
    {
        try {
            $correspondenciaAtualizada = $usuarioService->editarUsuario($request, $id);
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

    public function destroy(string $idCorrespondencia, UsuarioService $usuarioService): JsonResponse
    {
        try {
            $usuarioService->apagarUsuario($idCorrespondencia);
            return response()->json([
                "success" => "Correspondência deletada com sucesso"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }

    }
}
