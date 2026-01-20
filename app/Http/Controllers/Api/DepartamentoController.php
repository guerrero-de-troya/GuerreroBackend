<?php

namespace App\Http\Controllers\Api;

use App\Services\UbicacionService;
use Illuminate\Http\JsonResponse;

class DepartamentoController extends BaseController
{
    public function __construct(
        private readonly UbicacionService $ubicacionService
    ) {}

    /**
     * Obtener todos los departamentos
     */
    public function index(): JsonResponse
    {
        try {
            $departamentos = $this->ubicacionService->getDepartamentos();

            return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener departamentos: '.$e->getMessage(), 500);
        }
    }

    /**
     * Obtener departamentos por país
     */
    public function byPais(int $paisId): JsonResponse
    {
        try {
            $departamentos = $this->ubicacionService->getDepartamentosByPais($paisId);

            return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener departamentos: '.$e->getMessage(), 500);
        }
    }
}
