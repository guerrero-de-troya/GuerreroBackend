<?php

namespace App\Actions\Auth;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Verified;

class VerifyEmailAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId): array
    {
        $user = $this->userRepository->find($userId);

        if (! $user) {
            return [
                'message' => 'Usuario no encontrado.',
                'success' => false,
                'statusCode' => 404,
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'message' => 'El email ya fue verificado.',
                'success' => false,
                'statusCode' => 400,
            ];
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return [
            'message' => 'Email verificado exitosamente.',
            'success' => true,
            'statusCode' => 200,
        ];
    }
}
