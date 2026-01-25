<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Auth\ForgotPasswordHttpMapper;
use App\Http\Mappers\Auth\ResetPasswordHttpMapper;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ForgotPasswordAction $forgotPasswordAction,
        private readonly ResetPasswordAction $resetPasswordAction,
        private readonly ForgotPasswordHttpMapper $forgotMapper,
        private readonly ResetPasswordHttpMapper $resetMapper
    ) {}

    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->forgotPasswordAction->execute($request->toDto());

        return $this->forgotMapper->toResponse($result);
    }

    public function showResetForm(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Token de restablecimiento de contraseña',
            'data' => [
                'token' => $request->query('token'),
                'email' => $request->query('email'),
            ]
        ]);
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->resetPasswordAction->execute($request->toDto());

        return $this->resetMapper->toResponse($result);
    }
}
