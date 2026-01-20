<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdatePersonaRequest;
use App\Http\Resources\PersonaResource;
use App\Services\PersonaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PersonaController extends BaseController
{
    public function __construct(
        private readonly PersonaService $personaService
    ) {}

    public function index(): JsonResponse
    {
        $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
        $personas = $this->personaService->getAllPersonas($relations);

        return $this->success(
            PersonaResource::collection($personas),
            'Personas obtenidas exitosamente'
        );
    }

    public function show(int $id): JsonResponse
    {
        $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps', 'user'];
        $persona = $this->personaService->getPersonaById($id, $relations);

        return $this->success(
            new PersonaResource($persona),
            'Persona obtenida exitosamente'
        );
    }

    public function update(UpdatePersonaRequest $request, int $id): JsonResponse
    {
        $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
        $persona = $this->personaService->updatePersona($id, $request->validated(), $relations);

        return $this->success(
            new PersonaResource($persona),
            'Persona actualizada exitosamente'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->personaService->deletePersona($id);

        return $this->success(
            null,
            'Persona eliminada exitosamente'
        );
    }

    public function profile(): JsonResponse
    {
        $user = Auth::user();
        $user->load('persona');

        if (! $user->hasProfile()) {
            return $this->success(
                [
                    'has_profile' => false,
                    'profile' => null,
                ],
                'El usuario no tiene un perfil creado'
            );
        }

        $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
        $persona = $this->personaService->getPersonaById($user->persona_id, $relations);

        return $this->success(
            [
                'has_profile' => true,
                'profile' => new PersonaResource($persona),
            ],
            'Perfil obtenido exitosamente'
        );
    }
}
