<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
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
        private readonly ResetPasswordAction $resetPasswordAction
    ) {}

    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->forgotPasswordAction->execute($request->toDto());

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
