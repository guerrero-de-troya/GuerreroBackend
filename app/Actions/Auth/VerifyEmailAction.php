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
                'success' => false,
                'message' => 'Usuario no encontrado.',
                'statusCode' => 404,
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'El email ya fue verificado.',
                'statusCode' => 400,
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
