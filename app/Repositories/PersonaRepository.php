<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\Traits\BaseRepositoryTrait;
use Illuminate\Database\Eloquent\Collection;

class PersonaRepository implements PersonaRepositoryInterface
{
    use BaseRepositoryTrait;

    public function __construct()
    {
        $this->initializeRepository();
    }

    protected function model(): string
    {
        return Persona::class;
    }

    public function findOrFailWithRelations(int|string $id, array $relations = []): Persona
    {
        $query = $this->model->newQuery();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->findOrFail($id);
    }

    public function allWithRelations(array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->get();
    }

    public function existsByNumeroDocumento(string $numeroDocumento): bool
    {
        return $this->model->newQuery()
            ->where('numero_documento', strtoupper($numeroDocumento))
            ->exists();
    }

    public function existsByTelefono(string $telefono): bool
    {
        return $this->model->newQuery()
            ->where('telefono', strtoupper($telefono))
            ->exists();
    }
}
