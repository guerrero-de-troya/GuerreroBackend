<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

abstract class BaseController extends Controller
{
    protected function success(mixed $data, string $message = 'Operación exitosa', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

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

    protected function resourceResponse(JsonResource $resource, string $message = 'Operación exitosa', int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $resource,
        ];

        return response()->json($response, $statusCode);
    }

    protected function created(mixed $data, string $message = 'Recurso creado exitosamente'): JsonResponse
    {
        return $this->success($data, $message, Response::HTTP_CREATED);
    }

    protected function noContent(string $message = 'Operación exitosa'): JsonResponse
    {
        return $this->success(null, $message, Response::HTTP_NO_CONTENT);
    }
}
