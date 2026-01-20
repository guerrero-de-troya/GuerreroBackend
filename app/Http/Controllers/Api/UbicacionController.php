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
        $paises = $this->ubicacionService->getPaises();

        return $this->success($paises, 'Países obtenidos exitosamente');
    }

    public function departamentos(): JsonResponse
    {
        $departamentos = $this->ubicacionService->getDepartamentos();

        return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
    }

    public function departamentosByPais(int $paisId): JsonResponse
    {
        $departamentos = $this->ubicacionService->getDepartamentosByPais($paisId);

        return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
    }

    public function municipiosByDepartamento(int $departamentoId): JsonResponse
    {
        $municipios = $this->ubicacionService->getMunicipiosByDepartamento($departamentoId);

        return $this->success($municipios, 'Municipios obtenidos exitosamente');
    }
}
