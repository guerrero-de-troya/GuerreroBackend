<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Password Reset Controller
 *
 * Controla las peticiones HTTP relacionadas con restablecimiento de contraseña.
 */
class PasswordResetController extends BaseController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Enviar email para restablecer contraseña
     */
    public function forgot(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Convertir email a mayúsculas
        $email = strtoupper($request->email);

        // Verificar si el usuario existe
        if (! $this->userRepository->existsByEmail($email)) {
            return $this->success(
                null,
                'Si el email existe, se enviará un enlace para restablecer la contraseña.'
            );
        }

        $status = Password::sendResetLink(
            ['email' => $email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->success(
                null,
                'Se ha enviado un enlace para restablecer la contraseña a tu email.'
            );
        }

        return $this->error(
            'Error al enviar el enlace de restablecimiento.',
            500
        );
    }

    /**
     * Restablecer contraseña
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        // Convertir email a mayúsculas
        $email = strtoupper($request->email);

        $status = Password::reset(
            [
                'email' => $email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token' => $request->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->success(
                null,
                'Contraseña restablecida exitosamente.'
            );
        }

        return $this->error(
            'Error al restablecer la contraseña. El token puede ser inválido o haber expirado.',
            400
        );
    }
}
