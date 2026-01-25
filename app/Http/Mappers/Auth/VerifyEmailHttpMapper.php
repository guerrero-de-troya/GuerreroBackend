<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\VerifyEmailResult;
use Illuminate\Http\JsonResponse;

class VerifyEmailHttpMapper
{
    public function toResponse(VerifyEmailResult $result): JsonResponse
    {
        return match ($result->reason) {
            'verified' => response()->json([
                'success' => true,
                'message' => 'Email verificado exitosamente.',
            ], 200),

            'already_verified' => response()->json([
                'success' => true,
                'message' => 'El email ya fue verificado.',
            ], 200),

            'user_not_found' => response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.',
            ], 404),

            'invalid_hash' => response()->json([
                'success' => false,
                'message' => 'Enlace de verificación inválido.',
            ], 403),

            default => response()->json([
                'success' => false,
                'message' => 'Error desconocido.',
            ], 500),
        };
    }
}
