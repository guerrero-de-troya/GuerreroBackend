<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Repository
 *
 * Implementación base que proporciona operaciones CRUD genéricas.
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * Modelo asociado al repositorio
     */
    protected Model $model;

    /**
     * Crear una nueva instancia del repositorio
     */
    public function __construct()
    {
        $this->model = $this->makeModel();
    }

    /**
     * Obtener el nombre de la clase del modelo
     *
     * @return class-string<Model>
     */
    abstract protected function model(): string;

    /**
     * Crear una nueva instancia del modelo
     */
    protected function makeModel(): Model
    {
        $model = app($this->model());

        return $model;
    }

    /**
     * Obtener todos los registros
     *
     * @return Collection<int, Model>
     */
    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    /**
     * Buscar un registro por ID
     */
    public function find(int|string $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    /**
     * Buscar un registro por ID o lanzar excepción
     */
    public function findOrFail(int|string $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    /**
     * Crear un nuevo registro
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * Actualizar un registro existente
     *
     * @param  array<string, mixed>  $data
     */
    public function update(int|string $id, array $data): Model
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model->fresh();
    }

    /**
     * Eliminar un registro
     */
    public function delete(int|string $id): bool
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }

    /**
     * Verificar si existe un registro
     */
    public function exists(int|string $id): bool
    {
        return $this->model->newQuery()->where('id', $id)->exists();
    }

    /**
     * Obtener el modelo asociado al repositorio
     *
     * @return class-string<Model>
     */
    public function getModel(): string
    {
        return $this->model();
    }
}
