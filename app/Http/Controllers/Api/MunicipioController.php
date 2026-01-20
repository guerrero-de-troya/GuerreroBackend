<?php

namespace App\Http\Controllers\Api;

use App\Services\UbicacionService;
use Illuminate\Http\JsonResponse;

class MunicipioController extends BaseController
{
    public function __construct(
        private readonly UbicacionService $ubicacionService
    ) {}

    /**
     * Obtener municipios por departamento
     */
    public function byDepartamento(int $departamentoId): JsonResponse
    {
        try {
            $municipios = $this->ubicacionService->getMunicipiosByDepartamento($departamentoId);

            return $this->success($municipios, 'Municipios obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener municipios: '.$e->getMessage(), 500);
        }
    }
}
