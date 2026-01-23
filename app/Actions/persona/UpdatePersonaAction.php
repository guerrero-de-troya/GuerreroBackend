<?php

namespace App\Actions\Persona;

use App\Data\Persona\UpdatePersonaData;
use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;

class UpdatePersonaAction
{
    public function __construct(
        private readonly PersonaRepositoryInterface $personaRepository
    ) {}

    public function execute(int $id, UpdatePersonaData $data, array $relations = []): Persona
    {
        $persona = $this->personaRepository->update($id, $data->toArray());

        if (! empty($relations)) {
            $persona->load($relations);
        }

        return $persona;
    }
}
