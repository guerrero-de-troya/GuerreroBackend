<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\RegisterResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class RegisterHttpMapper
{
    use ApiResponse;

    public function toResponse(RegisterResult $result): JsonResponse
    {
        return match ($result->reason) {
            'success' => $this->created(
                data: [
                    'user' => $result->user,
                    'token' => $result->token,
                ],
                message: 'Usuario registrado exitosamente. Por favor verifica tu email.'
            ),

            'email_already_exists' => $this->error(
                message: 'El email ya está registrado.',
                statusCode: 422
            ),

            default => $this->error(
                message: 'Error desconocido.',
                statusCode: 500
            ),
        };
    }
}
