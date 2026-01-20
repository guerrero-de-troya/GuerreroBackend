<?php

namespace App\Http\Controllers\Api;

use App\Services\UbicacionService;
use Illuminate\Http\JsonResponse;

class UbicacionController extends BaseController
{
    public function __construct(
        private readonly UbicacionService $ubicacionService
    ) {}

    public function paises(): JsonResponse
    {
        try {
            $paises = $this->ubicacionService->getPaises();

            return $this->success($paises, 'Países obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener países: '.$e->getMessage(), 500);
        }
    }

    public function departamentos(): JsonResponse
    {
        try {
            $departamentos = $this->ubicacionService->getDepartamentos();

            return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener departamentos: '.$e->getMessage(), 500);
        }
    }

    public function departamentosByPais(int $paisId): JsonResponse
    {
        try {
            $departamentos = $this->ubicacionService->getDepartamentosByPais($paisId);

            return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener departamentos: '.$e->getMessage(), 500);
        }
    }

    public function municipiosByDepartamento(int $departamentoId): JsonResponse
    {
        try {
            $municipios = $this->ubicacionService->getMunicipiosByDepartamento($departamentoId);

            return $this->success($municipios, 'Municipios obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener municipios: '.$e->getMessage(), 500);
        }
    }
}
