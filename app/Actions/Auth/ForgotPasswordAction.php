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
     * @return array{message: string, isError: bool, statusCode: int}
     */
    public function execute(ForgotPasswordData $data): array
    {
        $email = strtoupper($data->email);

        if (! $this->userRepository->existsByEmail($email)) {
            return [
                'message' => 'Si el email existe, se enviará un enlace para restablecer la contraseña.',
                'isError' => false,
                'statusCode' => 200,
            ];
        }

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'message' => 'Se ha enviado un enlace para restablecer la contraseña a tu email.',
                'isError' => false,
                'statusCode' => 200,
            ];
        }

        return [
            'message' => 'Error al enviar el enlace de restablecimiento.',
            'isError' => true,
            'statusCode' => 500,
        ];
    }
}
