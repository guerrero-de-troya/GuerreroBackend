<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\LoginResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class LoginHttpMapper
{
    use ApiResponse;

    public function toResponse(LoginResult $result): JsonResponse
    {
        return match ($result->reason) {
            'success' => $this->success(
                data: [
                    'user' => $result->user,
                    'token' => $result->token,
                ],
                message: 'Sesión iniciada exitosamente'
            ),

            'invalid_credentials' => $this->error(
                message: 'Credenciales inválidas.',
                statusCode: 401
            ),

            default => $this->error(
                message: 'Error desconocido.',
                statusCode: 500
            ),
        };
    }
}
