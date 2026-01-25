<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\ForgotPasswordResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ForgotPasswordHttpMapper
{
    use ApiResponse;

    public function toResponse(ForgotPasswordResult $result): JsonResponse
    {
        return match ($result->reason) {
            'sent' => $this->success(
                message: 'Se ha enviado un enlace para restablecer la contraseña a tu email.'
            ),

            'throttled' => $this->error(
                message: 'Debes esperar antes de volver a solicitar el restablecimiento.',
                statusCode: 429
            ),

            default => $this->success(
                message: 'Si el email existe y está verificado, se enviará un enlace para restablecer la contraseña.'
            ),
        };
    }
}
