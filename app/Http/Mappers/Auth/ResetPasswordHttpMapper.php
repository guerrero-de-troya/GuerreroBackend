<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\ResetPasswordResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ResetPasswordHttpMapper
{
    use ApiResponse;

    public function toResponse(ResetPasswordResult $result): JsonResponse
    {
        return match ($result->reason) {
            'password_reset' => $this->success(
                message: 'Contraseña restablecida exitosamente.'
            ),

            'invalid_token' => $this->error(
                message: 'El token es inválido o ha expirado.',
                statusCode: 400
            ),

            default => $this->error(
                message: 'Error desconocido.',
                statusCode: 500
            ),
        };
    }
}
