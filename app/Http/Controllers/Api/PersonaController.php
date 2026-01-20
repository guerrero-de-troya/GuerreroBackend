<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdatePersonaRequest;
use App\Http\Resources\PersonaResource;
use App\Services\PersonaService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PersonaController extends BaseController
{
    public function __construct(
        private readonly PersonaService $personaService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
            $personas = $this->personaService->getAllPersonas($relations);

            return $this->success(
                PersonaResource::collection($personas),
                'Personas obtenidas exitosamente'
            );
        } catch (\Exception $e) {
            return $this->error('Error al obtener personas: '.$e->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps', 'user'];
            $persona = $this->personaService->getPersonaById($id, $relations);

            return $this->success(
                new PersonaResource($persona),
                'Persona obtenida exitosamente'
            );
        } catch (ModelNotFoundException $e) {
            return $this->error('Persona no encontrada', 404);
        } catch (\Exception $e) {
            return $this->error('Error al obtener persona: '.$e->getMessage(), 500);
        }
    }

    public function update(UpdatePersonaRequest $request, int $id): JsonResponse
    {
        try {
            $relations = ['tipoDocumento', 'genero', 'nivel', 'talla', 'eps'];
            $persona = $this->personaService->updatePersona($id, $request->validated(), $relations);

            return $this->success(
                new PersonaResource($persona),
                'Persona actualizada exitosamente'
            );
        } catch (ModelNotFoundException $e) {
            return $this->error('Persona no encontrada', 404);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 403);
        } catch (\Exception $e) {
            return $this->error('Error al actualizar persona: '.$e->getMessage(), 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->personaService->deletePersona($id);

            return $this->success(
                null,
                'Persona eliminada exitosamente'
            );
        } catch (ModelNotFoundException $e) {
            return $this->error('Persona no encontrada', 404);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 403);
        } catch (\Exception $e) {
            return $this->error('Error al eliminar persona: '.$e->getMessage(), 500);
        }
    }

    public function profile(): JsonResponse
    {
        try {
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
        } catch (\Exception $e) {
            return $this->error('Error al obtener perfil: '.$e->getMessage(), 500);
        }
    }
}
