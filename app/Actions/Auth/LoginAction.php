<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginData;
use App\Data\User\UserData;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(LoginData $data): array
    {
        $email = strtoupper($data->email);

        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($data->password, $user->password)) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => UserData::from($user),
            'token' => $token,
        ];
    }
}
