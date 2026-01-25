<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait BaseRepositoryTrait
{
    protected Model $model;

    protected function initializeRepository(): void
    {
        $this->model = $this->makeModel();
    }

    abstract protected function model(): string;

    protected function makeModel(): Model
    {
        $model = app($this->model());

        return $model;
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function find(int|string $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int|string $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int|string $id, array $data): Model
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model->fresh();
    }

    public function delete(int|string $id): bool
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }

    public function exists(int|string $id): bool
    {
        return $this->model->newQuery()->where('id', $id)->exists();
    }

    public function getModel(): string
    {
        return $this->model();
    }

    protected function withRelationsIfNotEmpty($query, array $relations = [])
    {
        return ! empty($relations) ? $query->with($relations) : $query;
    }
}
