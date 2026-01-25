<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\SendEmailVerificationResult;
use Illuminate\Http\JsonResponse;

class SendEmailVerificationHttpMapper
{
    public function toResponse(SendEmailVerificationResult $result): JsonResponse
    {
        return match ($result->reason) {
            'sent' => response()->json([
                'success' => true,
                'message' => 'Email de verificación reenviado.',
            ], 200),

            'already_verified' => response()->json([
                'success' => false,
                'message' => 'El email ya ha sido verificado.',
            ], 400),

            'throttled' => response()->json([
                'success' => false,
                'message' => 'Demasiados intentos. Intenta nuevamente más tarde.',
            ], 429),

            default => response()->json([
                'success' => false,
                'message' => 'Error desconocido.',
            ], 500),
        };
    }
}
