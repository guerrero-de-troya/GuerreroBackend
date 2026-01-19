<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Repository Interface
 *
 * Define el contrato base para todos los repositorios.
 * Sigue los principios DIP (Dependency Inversion) e ISP (Interface Segregation).
 */
interface RepositoryInterface
{
    /**
     * Obtener todos los registros
     *
     * @return Collection<int, Model>
     */
    public function all(): Collection;

    /**
     * Buscar un registro por ID
     */
    public function find(int|string $id): ?Model;

    /**
     * Buscar un registro por ID o lanzar excepción
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int|string $id): Model;

    /**
     * Crear un nuevo registro
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model;

    /**
     * Actualizar un registro existente
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int|string $id, array $data): Model;

    /**
     * Eliminar un registro
     */
    public function delete(int|string $id): bool;

    /**
     * Verificar si existe un registro
     */
    public function exists(int|string $id): bool;

    /**
     * Obtener el modelo asociado al repositorio
     *
     * @return class-string<Model>
     */
    public function getModel(): string;
}
