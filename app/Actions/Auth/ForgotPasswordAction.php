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

    /**
     * @return array{success: bool, message: string, statusCode: int}
     */
    public function execute(ForgotPasswordData $data): array
    {
        $email = strtoupper($data->email);

        if (! $this->userRepository->existsByEmail($email)) {
            return [
                'success' => true,
                'message' => 'Si el email existe, se enviará un enlace para restablecer la contraseña.',
                'statusCode' => 200,
            ];
        }

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'success' => true,
                'message' => 'Se ha enviado un enlace para restablecer la contraseña a tu email.',
                'statusCode' => 200,
            ];
        }

        return [
            'success' => false,
            'message' => 'Error al enviar el enlace de restablecimiento.',
            'statusCode' => 500,
        ];
    }
}
