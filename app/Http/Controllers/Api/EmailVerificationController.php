<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Email Verification Controller
 *
 * Controla las peticiones HTTP relacionadas con verificación de email.
 */
class EmailVerificationController extends BaseController
{
    /**
     * Reenviar notificación de verificación de email
     */
    public function send(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->error('El email ya ha sido verificado.', 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->success(null, 'Email de verificación enviado exitosamente.');
    }

    /**
     * Verificar email del usuario
     */
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->error('El email ya ha sido verificado.', 400);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->success(null, 'Email verificado exitosamente.');
    }
}
