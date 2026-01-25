<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\ForgotPasswordResult;
use Illuminate\Http\JsonResponse;

class ForgotPasswordHttpMapper
{
    public function toResponse(ForgotPasswordResult $result): JsonResponse
    {
        return match ($result->reason) {
            'sent' => response()->json([
                'success' => true,
                'message' => 'Se ha enviado un enlace para restablecer la contraseña a tu email.',
            ], 200),

            'throttled' => response()->json([
                'success' => false,
                'message' => 'Debes esperar antes de volver a solicitar el restablecimiento.',
            ], 429),

            default => response()->json([
                'success' => true,
                'message' => 'Si el email existe y está verificado, se enviará un enlace para restablecer la contraseña.',
            ], 200),
        };
    }
}
