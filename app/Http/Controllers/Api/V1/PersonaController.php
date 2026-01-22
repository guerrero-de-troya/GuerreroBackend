<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Http\Resources\Api\V1\PersonaResource;
use App\Traits\ApiResponse;
use App\Services\PersonaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    use ApiResponse;

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

    public function store(StorePersonaRequest $request): JsonResponse
    {
        $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
        $persona = $this->personaService->createPersona($request->validated(), $relations);

        return $this->created(
            new PersonaResource($persona),
            'Persona creada exitosamente'
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

    public function destroy(int $id): Response
    {
        $this->personaService->deletePersona($id);

        return $this->noContent();
    }

    public function profile(): JsonResponse
    {
        $user = Auth::user();

        if ($user->persona_id === null || ! $user->hasProfile()) {
            return $this->success(
                [
                    'has_profile' => false,
                    'profile' => null,
                ],
                'El usuario no tiene un perfil creado'
            );
        }

        $user->load('persona');

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
