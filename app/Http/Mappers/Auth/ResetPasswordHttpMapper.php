<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\ResetPasswordResult;
use Illuminate\Http\JsonResponse;

class ResetPasswordHttpMapper
{
    public function toResponse(ResetPasswordResult $result): JsonResponse
    {
        return match ($result->reason) {
            'password_reset' => response()->json([
                'success' => true,
                'message' => 'Contraseña restablecida exitosamente.',
            ], 200),

            'invalid_token' => response()->json([
                'success' => false,
                'message' => 'El token es inválido o ha expirado.',
            ], 400),

            default => response()->json([
                'success' => false,
                'message' => 'Error desconocido.',
            ], 500),
        };
    }
}
