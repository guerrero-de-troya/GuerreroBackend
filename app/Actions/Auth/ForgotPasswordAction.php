<?php

namespace App\Actions\Auth;

use App\Data\Auth\ForgotPasswordData;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Password;

class ForgotPasswordAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(ForgotPasswordData $data): array
    {
        $email = strtolower($data->email);

        if (! $this->userRepository->existsByEmail($email)) {
            return [
                'success' => true,
                'message' => 'Si el email existe, se enviará un enlace para restablecer la contraseña.',
                'statusCode' => 200,
            ];
        }

        $status = Password::sendResetLink(['email' => $email]);

        return match ($status) {
            Password::RESET_LINK_SENT => [
                'success' => true,
                'message' => 'Se ha enviado un enlace para restablecer la contraseña a tu email.',
                'statusCode' => 200,
            ],

            Password::RESET_THROTTLED => [
                'success' => false,
                'message' => 'Debes esperar antes de volver a solicitar el restablecimiento.',
                'statusCode' => 429,
            ],

            default => [
                'success' => false,
                'message' => 'No se pudo enviar el enlace de restablecimiento.',
                'statusCode' => 500,
            ],
        };
    }
}