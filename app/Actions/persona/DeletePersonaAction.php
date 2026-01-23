<?php

namespace App\Actions\Persona;

use App\Repositories\Contracts\PersonaRepositoryInterface;

class DeletePersonaAction
{
    public function __construct(
        private readonly PersonaRepositoryInterface $personaRepository
    ) {}

    public function execute(int $id): bool
    {
        return $this->personaRepository->delete($id);
    }
}
