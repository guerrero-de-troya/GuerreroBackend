<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\SendEmailVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

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

    public function verify(VerifyEmailRequest $request): JsonResponse|RedirectResponse
    {
        $result = $this->verifyEmailAction->execute($request->toDto());

        $frontendBase = rtrim(Config::get('app.frontend_url', Config::get('app.url')), '/');
        $redirectTo = $frontendBase.'/verificar-email';

        if (! $request->expectsJson()) {
            $params = match ($result->reason) {
                'verified', 'already_verified' => ['verified' => '1'],
                default => ['verified' => '0', 'error' => $this->messageForReason($result->reason)],
            };

            return redirect($redirectTo.'?'.http_build_query($params));
        }

        return match ($result->reason) {
            'verified' => $this->success(message: 'Email verificado exitosamente.'),
            'already_verified' => $this->success(message: 'El email ya fue verificado.'),
            'user_not_found' => $this->error(message: 'Usuario no encontrado.', statusCode: 404),
            'invalid_hash' => $this->error(message: 'Enlace de verificación inválido.', statusCode: 403),
            default => $this->error(message: 'Error desconocido.', statusCode: 500),
        };
    }

    private function messageForReason(string $reason): string
    {
        return match ($reason) {
            'user_not_found' => 'Usuario no encontrado.',
            'invalid_hash' => 'Enlace de verificación inválido.',
            default => 'No se pudo verificar el correo.',
        };
    }
}
