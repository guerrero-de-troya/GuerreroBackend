<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * User Repository
 * Implementación del repositorio para usuarios.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Obtener el nombre de la clase del modelo
     *
     * @return class-string<Model>
     */
    protected function model(): string
    {
        return User::class;
    }

    /**
     * Buscar usuario por email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    /**
     * Verificar si existe un usuario por email
     */
    public function existsByEmail(string $email): bool
    {
        return $this->model->newQuery()->where('email', $email)->exists();
    }

    /**
     * Crear token para un usuario
     */
    public function createToken(User $user, string $tokenName = 'auth-token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    /**
     * Revocar el token actual del usuario
     */
    public function revokeCurrentToken(User $user): void
    {
        $token = $user->currentAccessToken();
        if ($token !== null) {
            /** @var \Laravel\Sanctum\PersonalAccessToken $token */
            $token->delete();
        }
    }

    /**
     * Revocar todos los tokens del usuario
     */
    public function revokeAllTokens(User $user): void
    {
        /** @var \Illuminate\Database\Eloquent\Relations\MorphMany $tokens */
        $tokens = $user->tokens();
        $tokens->delete();
    }
}
