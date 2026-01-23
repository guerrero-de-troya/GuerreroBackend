<?php

namespace App\Actions\Auth;

use App\Repositories\Contracts\UserRepositoryInterface;

class LogoutAllAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId): void
    {
        $user = $this->userRepository->findOrFail($userId);
        $user->tokens()->delete();
    }
}
