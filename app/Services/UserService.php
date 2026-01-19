<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * User Service
 */
class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Obtener todos los usuarios
     *
     * @return Collection<int, User>
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Obtener un usuario por ID
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getUserById(int $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    /**
     * Crear un nuevo usuario
     *
     * @param  array<string, mixed>  $data
     */
    public function createUser(array $data): User
    {
        return $this->userRepository->create($data);
    }

    /**
     * Actualizar un usuario existente
     *
     * @param  array<string, mixed>  $data
     */
    public function updateUser(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    /**
     * Eliminar un usuario
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Buscar usuario por email
     */
    public function getUserByEmail(string $email): ?User
    {
        // Convertir email a mayúsculas para búsqueda
        return $this->userRepository->findByEmail(strtoupper($email));
    }
}
