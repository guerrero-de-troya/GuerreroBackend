<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginData;
use App\Data\User\UserData;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(LoginData $data): array
    {
        $email = strtolower($data->email);

        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($data->password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Credenciales inválidas.',
                'statusCode' => 401,
            ];
        }

        if (! $user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'Email no verificado. Por favor verifica tu email.',
                'statusCode' => 403,
            ];
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Sesión iniciada exitosamente',
            'data' => [
                'user' => UserData::from($user),
                'token' => $token,
            ],
            'statusCode' => 200,
        ];
    }
}
