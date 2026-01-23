<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterData;
use App\Data\User\UserData;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(RegisterData $data): array
    {
        $user = $this->userRepository->create([
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'persona_id' => null,
        ]);

        $user = $user->fresh();

        event(new Registered($user));

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Usuario registrado exitosamente. Por favor verifica tu email.',
            'data' => [
                'user' => UserData::from($user),
                'token' => $token,
            ],
            'statusCode' => 201,
        ];
    }
}
