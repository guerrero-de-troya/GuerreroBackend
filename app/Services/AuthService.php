<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PersonaRepositoryInterface $personaRepository
    ) {}

    public function register(array $data): array
    {
        $systemPersona = $this->personaRepository->getSystemPersona();

        $user = $this->userRepository->create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'persona_id' => $systemPersona->id,
        ]);

        $user = $user->fresh();

        event(new Registered($user));

        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(string $email, string $password): array
    {
        $email = strtoupper($email);

        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logoutAll(int $userId): void
    {
        $user = $this->userRepository->findOrFail($userId);
        $user->tokens()->delete();
    }

    public function createToken(User $user, string $tokenName = 'auth-token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }
}
