<?php

namespace App\Services;

use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaService
{
    public function __construct(
        private readonly PersonaRepositoryInterface $personaRepository
    ) {}

    public function getAllPersonas(array $relations = []): Collection
    {
        if (empty($relations)) {
            return $this->personaRepository->all();
        }

        return $this->personaRepository->allWithRelations($relations);
    }

    public function getPersonaById(int $id, array $relations = []): Persona
    {
        if (empty($relations)) {
            return $this->personaRepository->findOrFail($id);
        }

        return $this->personaRepository->findOrFailWithRelations($id, $relations);
    }

    public function createPersona(array $data, array $relations = []): Persona
    {
        $persona = $this->personaRepository->create($data);

        if (! empty($relations)) {
            $persona->load($relations);
        }

        return $persona;
    }

    public function updatePersona(int $id, array $data, array $relations = []): Persona
    {
        $persona = $this->personaRepository->update($id, $data);

        if (! empty($relations)) {
            $persona->load($relations);
        }

        return $persona;
    }

    public function deletePersona(int $id): bool
    {
        return $this->personaRepository->delete($id);
    }
}
