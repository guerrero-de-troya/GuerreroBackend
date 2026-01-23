<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Persona\CreatePersonaAction;
use App\Actions\Persona\DeletePersonaAction;
use App\Actions\Persona\GetMyProfileAction;
use App\Actions\Persona\UpdatePersonaAction;
use App\Data\Persona\PersonaData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Services\Query\PersonaQueryService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PersonaQueryService $personaQueryService,
        private readonly CreatePersonaAction $createPersonaAction,
        private readonly UpdatePersonaAction $updatePersonaAction,
        private readonly DeletePersonaAction $deletePersonaAction,
        private readonly GetMyProfileAction $getMyProfileAction
    ) {}

    public function index(): JsonResponse
    {
        $personas = $this->personaQueryService->all(
            $this->personaQueryService->basicRelations()
        );

        return $this->success(
            $personas->map(fn ($persona) => PersonaData::from($persona)),
            'Personas obtenidas exitosamente'
        );
    }

    public function show(int $id): JsonResponse
    {
        $persona = $this->personaQueryService->findById(
            $id,
            $this->personaQueryService->fullRelations()
        );

        return $this->success(
            PersonaData::from($persona),
            'Persona obtenida exitosamente'
        );
    }

    public function store(StorePersonaRequest $request): JsonResponse
    {
        $persona = $this->createPersonaAction->execute(
            $request->toDto(),
            $this->personaQueryService->basicRelations()
        );

        return $this->created(
            PersonaData::from($persona),
            'Persona creada exitosamente'
        );
    }

    public function update(UpdatePersonaRequest $request, int $id): JsonResponse
    {
        $persona = $this->updatePersonaAction->execute(
            $id,
            $request->toDto(),
            $this->personaQueryService->basicRelations()
        );

        return $this->success(
            PersonaData::from($persona),
            'Persona actualizada exitosamente'
        );
    }

    public function destroy(int $id): Response
    {
        $this->deletePersonaAction->execute($id);

        return $this->noContent();
    }

    public function profile(Request $request): JsonResponse
    {
        $profileData = $this->getMyProfileAction->execute($request->user());

        $message = $profileData->hasProfile
            ? 'Perfil obtenido exitosamente'
            : 'El usuario no tiene un perfil creado';

        return $this->success(
            $profileData,
            $message
        );
    }
}
