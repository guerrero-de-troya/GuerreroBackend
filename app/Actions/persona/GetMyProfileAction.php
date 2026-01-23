<?php

namespace App\Actions\Persona;

use App\Data\Persona\PersonaData;
use App\Data\Persona\ProfileData;
use App\Models\User;
use App\Services\Query\PersonaQueryService;

class GetMyProfileAction
{
    public function __construct(
        private readonly PersonaQueryService $personaQueryService
    ) {}

    public function execute(User $user): ProfileData
    {
        if ($user->persona_id === null || ! $user->hasProfile()) {
            return new ProfileData(
                hasProfile: false,
                profile: null
            );
        }

        $persona = $this->personaQueryService->findById(
            $user->persona_id,
            $this->personaQueryService->basicRelations()
        );

        return new ProfileData(
            hasProfile: true,
            profile: PersonaData::from($persona)
        );
    }
}
