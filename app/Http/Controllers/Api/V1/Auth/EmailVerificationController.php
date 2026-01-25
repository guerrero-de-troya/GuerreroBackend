<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\SendEmailVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SendEmailVerificationAction $sendEmailVerificationAction,
        private readonly VerifyEmailAction $verifyEmailAction
    ) {}

    public function send(Request $request): JsonResponse
    {
        $result = $this->sendEmailVerificationAction->execute($request->user());

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

    public function verify(VerifyEmailRequest $request): JsonResponse
    {
        $result = $this->verifyEmailAction->execute($request->toDto());

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
