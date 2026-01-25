<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\SendEmailVerificationResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class SendEmailVerificationHttpMapper
{
    use ApiResponse;

    public function toResponse(SendEmailVerificationResult $result): JsonResponse
    {
        return match ($result->reason) {
            'sent' => $this->success(
                message: 'Email de verificación reenviado.'
            ),

            'already_verified' => $this->error(
                message: 'El email ya ha sido verificado.',
                statusCode: 400
            ),

            'throttled' => $this->error(
                message: 'Demasiados intentos. Intenta nuevamente más tarde.',
                statusCode: 429
            ),

            default => $this->error(
                message: 'Error desconocido.',
                statusCode: 500
            ),
        };
    }
}
