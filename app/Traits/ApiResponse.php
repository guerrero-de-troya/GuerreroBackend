<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    protected function respond(bool $success, array $result): JsonResponse
    {
        if ($success) {
            return response()->json([
                'success' => true,
                'message' => $result['message'] ?? 'Operación exitosa',
                'data' => $result['data'] ?? null,
            ], $result['statusCode'] ?? Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Error en la operación',
            'errors' => $result['errors'] ?? null,
        ], $result['statusCode'] ?? Response::HTTP_BAD_REQUEST);
    }

    protected function success(
        mixed $data = null,
        string $message = 'Operación exitosa',
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function error(
        string $message = 'Error en la operación',
        int $statusCode = Response::HTTP_BAD_REQUEST,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    protected function noContent(): Response
    {
        return response()->noContent();
    }

    protected function created(
        mixed $data = null,
        string $message = 'Recurso creado exitosamente'
    ): JsonResponse {
        return $this->success($data, $message, Response::HTTP_CREATED);
    }
}
