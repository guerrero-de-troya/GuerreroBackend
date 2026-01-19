<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

/**
 * Auth Service
 *
 * Contiene la lógica de negocio para autenticación.
 */
class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PersonaRepositoryInterface $personaRepository
    ) {}

    /**
     * Registrar un nuevo usuario
     *
     * @param  array<string, mixed>  $data
     * @return array{user: User, token: string}
     */
    public function register(array $data): array
    {
        // Obtener o crear persona base del sistema
        $systemPersona = $this->personaRepository->getOrCreateSystemPersona();

        // Crear usuario con persona_id apuntando a la persona base del sistema
        $user = $this->userRepository->create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'persona_id' => $systemPersona->id,
        ]);

        // Recargar usuario con persona_id
        $user = $user->fresh();

        event(new Registered($user));

        $token = $this->userRepository->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Autenticar usuario y generar token
     *
     * @return array{user: User, token: string}
     *
     * @throws AuthenticationException
     */
    public function login(string $email, string $password): array
    {
        $email = strtoupper($email);

        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        $token = $this->userRepository->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Revocar el token actual del usuario
     */
    public function logout(int $userId): void
    {
        $user = $this->userRepository->findOrFail($userId);
        $this->userRepository->revokeCurrentToken($user);
    }

    /**
     * Revocar todos los tokens del usuario
     */
    public function logoutAll(int $userId): void
    {
        $user = $this->userRepository->findOrFail($userId);
        $this->userRepository->revokeAllTokens($user);
    }

    /**
     * Obtener usuario por ID
     */
    public function getAuthenticatedUser(int $userId): User
    {
        return $this->userRepository->findOrFail($userId);
    }
}
