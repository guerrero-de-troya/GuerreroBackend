<?php

namespace App\Repositories\Contracts;

use App\Models\User;

/**
 * User Repository Interface
 *
 * Define métodos específicos para el repositorio de usuarios.
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function existsByEmail(string $email): bool;

    public function createToken(User $user, string $tokenName = 'auth-token'): string;

    public function revokeCurrentToken(User $user): void;

    public function revokeAllTokens(User $user): void;
}
