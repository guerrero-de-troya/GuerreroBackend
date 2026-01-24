<?php

namespace App\Actions\Auth;

use App\Repositories\Contracts\UserRepositoryInterface;

class LogoutAllAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId): array
    {
        $user = $this->userRepository->findOrFail($userId);
        $user->tokens()->delete();

        return [
            'success' => true,
            'message' => 'Cierre de sesión en todos los dispositivos exitoso',
            'statusCode' => 200,
        ];
    }
}
