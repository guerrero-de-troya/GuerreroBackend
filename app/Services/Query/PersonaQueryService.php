<?php

namespace App\Services\Query;

use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaQueryService
{
    public function __construct(
        private readonly PersonaRepositoryInterface $repository
    ) {}

    public function basicRelations(): array
    {
        return ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
    }

    public function fullRelations(): array
    {
        return ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps', 'user'];
    }

    public function all(array $relations = []): Collection
    {
        return empty($relations)
            ? $this->repository->all()
            : $this->repository->allWithRelations($relations);
    }

    public function findById(int $id, array $relations = []): Persona
    {
        return empty($relations)
            ? $this->repository->findOrFail($id)
            : $this->repository->findOrFailWithRelations($id, $relations);
    }
}
