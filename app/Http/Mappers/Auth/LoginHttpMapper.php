<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\LoginResult;
use Illuminate\Http\JsonResponse;

class LoginHttpMapper
{
    public function toResponse(LoginResult $result): JsonResponse
    {
        return match ($result->reason) {
            'success' => response()->json([
                'success' => true,
                'message' => 'Sesión iniciada exitosamente',
                'data' => [
                    'user' => $result->user,
                    'token' => $result->token,
                ],
            ], 200),

            'invalid_credentials' => response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas.',
            ], 401),

            default => response()->json([
                'success' => false,
                'message' => 'Error desconocido.',
            ], 500),
        };
    }
}
