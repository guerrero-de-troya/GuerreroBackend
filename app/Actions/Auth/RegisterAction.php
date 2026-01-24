<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterData;
use App\Data\User\UserData;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(RegisterData $data): array
    {
        $email = strtolower($data->email);

        if ($this->userRepository->existsByEmail($email)) {
            return [
                'success' => false,
                'message' => 'El email ya está registrado.',
                'statusCode' => 422,
            ];
        }

        $user = DB::transaction(function () use ($email, $data) {
            $user = $this->userRepository->create([
                'email' => $email,
                'password' => Hash::make($data->password),
                'persona_id' => null,
            ]);

            $user = $user->fresh();
            $user->assignRole('usuario');

            return $user;
        });

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
