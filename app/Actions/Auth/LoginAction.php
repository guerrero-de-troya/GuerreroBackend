<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginData;
use App\Data\Auth\Results\LoginResult;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Auth\PasswordService;
use App\Services\Auth\TokenService;

class LoginAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordService $passwordService,
        private readonly TokenService $tokenService
    ) {}

    public function execute(LoginData $data): LoginResult
    {
        $user = $this->userRepository->findByEmail($data->email);

        if (! $user || ! $this->passwordService->verify($data->password, $user->password)) {
            return LoginResult::invalidCredentials();
        }

        if (! $user->hasVerifiedEmail()) {
            return LoginResult::emailNotVerified();
        }

        // Limitar tokens activos a 5 dispositivos
        $this->tokenService->limitTokens($user, 5);

        $token = $this->tokenService->create($user);

        return LoginResult::success($user, $token);
    }
}
