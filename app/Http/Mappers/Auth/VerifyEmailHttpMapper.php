<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\VerifyEmailResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class VerifyEmailHttpMapper
{
    use ApiResponse;

    public function toResponse(VerifyEmailResult $result): JsonResponse
    {
        return match ($result->reason) {
            'verified' => $this->success(
                message: 'Email verificado exitosamente.'
            ),

            'already_verified' => $this->success(
                message: 'El email ya fue verificado.'
            ),

            'user_not_found' => $this->error(
                message: 'Usuario no encontrado.',
                statusCode: 404
            ),

            'invalid_hash' => $this->error(
                message: 'Enlace de verificación inválido.',
                statusCode: 403
            ),

            default => $this->error(
                message: 'Error desconocido.',
                statusCode: 500
            ),
        };
    }
}
