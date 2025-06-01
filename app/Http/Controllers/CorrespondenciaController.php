<?php

namespace App\Http\Controllers;

use App\Http\Services\CorrespondenciaService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CorrespondenciaController extends Controller
{
    public function index(CorrespondenciaService $correspondenciaService): JsonResponse
    {
        return response()->json($correspondenciaService->buscarCorrespondencias());
    }

    
    public function show(CorrespondenciaService $correspondenciaService): JsonResponse
    {
        return response()->json($correspondenciaService->buscarCorrespondenciasPorUsuario());
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


    public function destroy(string $idCorrespondencia, CorrespondenciaService $correspondenciaService): JsonResponse
    {
        $correspondenciaService->apagarCorrespondencia($idCorrespondencia);
        return response()->json([
            "success" => "Correspondência deletada com sucesso"
        ], 200);
    }
}
