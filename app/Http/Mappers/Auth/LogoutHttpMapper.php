<?php

namespace App\Http\Mappers\Auth;

use App\Data\Auth\Results\LogoutResult;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class LogoutHttpMapper
{
    use ApiResponse;

    public function toResponse(LogoutResult $result): JsonResponse
    {
        return $this->success(
            message: 'Cierre de sesión exitoso'
        );
    }
}
