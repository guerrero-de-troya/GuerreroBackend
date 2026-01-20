<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaRepository extends BaseRepository implements PersonaRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function model(): string
    {
        return Persona::class;
    }

    public function getSystemPersona(): Persona
    {
        return $this->model->newQuery()
            ->where('is_system', true)
            ->firstOrFail();
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
