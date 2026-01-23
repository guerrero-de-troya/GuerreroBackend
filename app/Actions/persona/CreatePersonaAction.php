<?php

namespace App\Actions\Persona;

use App\Data\Persona\StorePersonaData;
use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;

class CreatePersonaAction
{
    public function __construct(
        private readonly PersonaRepositoryInterface $personaRepository
    ) {}

    public function execute(StorePersonaData $data, array $relations = []): Persona
    {
        $persona = $this->personaRepository->create($data->toArray());

        if (! empty($relations)) {
            $persona->load($relations);
        }

        return $persona;
    }
}
