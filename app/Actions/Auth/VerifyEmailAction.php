<?php

namespace App\Actions\Auth;

use App\Data\Auth\VerifyEmailData;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Verified;

class VerifyEmailAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(VerifyEmailData $data): array
    {
        $user = $this->userRepository->find($data->id);

        if (! $user) {
            return [
                'success' => false,
                'message' => 'Usuario no encontrado.',
                'statusCode' => 404,
            ];
        }

        // Validar hash del email
        if (! hash_equals($data->hash, sha1($user->getEmailForVerification()))) {
            return [
                'success' => false,
                'message' => 'Enlace de verificación inválido.',
                'statusCode' => 403,
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => true,
                'message' => 'El email ya fue verificado.',
                'statusCode' => 200,
            ];
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return [
            'success' => true,
            'message' => 'Email verificado exitosamente.',
            'statusCode' => 200,
        ];
    }
}
