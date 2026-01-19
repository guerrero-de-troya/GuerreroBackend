<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * Base Controller para API
 *
 * Proporciona métodos comunes para respuestas JSON estructuradas.
 * Sigue el principio SRP (Single Responsibility).
 */
abstract class BaseController extends Controller
{
    /**
     * Respuesta exitosa con datos
     */
    protected function success(mixed $data, string $message = 'Operación exitosa', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Respuesta de error
     */
    protected function error(string $message = 'Error en la operación', int $statusCode = Response::HTTP_BAD_REQUEST, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Respuesta con recurso (API Resource)
     */
    protected function resourceResponse(JsonResource $resource, string $message = 'Operación exitosa', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $resource,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Respuesta de recurso creado
     */
    protected function created(mixed $data, string $message = 'Recurso creado exitosamente'): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_CREATED);
    }

    /**
     * Respuesta sin contenido
     */
    protected function noContent(string $message = 'Operación exitosa'): JsonResponse
    {
        return $this->success(null, $message, Response::HTTP_NO_CONTENT);
    }
}
