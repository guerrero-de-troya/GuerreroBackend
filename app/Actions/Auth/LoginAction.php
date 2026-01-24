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

        $passwordValid = $user && Hash::check($data->password, $user->password);

        if (! $passwordValid || ! $user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'Credenciales inválidas.',
                'statusCode' => 401,
            ];
        }

        // Limitar tokens activos a 5 dispositivos
        if ($user->tokens()->count() >= 5) {
            $user->tokens()->oldest()->first()?->delete();
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
