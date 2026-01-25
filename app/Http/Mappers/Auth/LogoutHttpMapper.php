<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\LogoutResult;
use Illuminate\Http\JsonResponse;

class LogoutHttpMapper
{
    public function toResponse(LogoutResult $result): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Cierre de sesión exitoso',
        ], 200);
    }
}
