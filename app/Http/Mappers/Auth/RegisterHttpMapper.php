<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\RegisterResult;
use Illuminate\Http\JsonResponse;

class RegisterHttpMapper
{
    public function toResponse(RegisterResult $result): JsonResponse
    {
        return match ($result->reason) {
            'success' => response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente. Por favor verifica tu email.',
                'data' => [
                    'user' => $result->user,
                    'token' => $result->token,
                ],
            ], 201),

            'email_already_exists' => response()->json([
                'success' => false,
                'message' => 'El email ya está registrado.',
            ], 422),

            default => response()->json([
                'success' => false,
                'message' => 'Error desconocido.',
            ], 500),
        };
    }
}
