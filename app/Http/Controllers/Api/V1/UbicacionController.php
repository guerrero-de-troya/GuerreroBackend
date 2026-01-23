<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Services\Query\UbicacionQueryService;
use Illuminate\Http\JsonResponse;

class UbicacionController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UbicacionQueryService $ubicacionQueryService
    ) {}

    public function paises(): JsonResponse
    {
        $paises = $this->ubicacionQueryService->getPaises();

        return $this->success($paises, 'Países obtenidos exitosamente');
    }

    public function departamentos(): JsonResponse
    {
        $departamentos = $this->ubicacionQueryService->getDepartamentos();

        return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
    }

    public function departamentosByPais(int $paisId): JsonResponse
    {
        $departamentos = $this->ubicacionQueryService->getDepartamentosByPais($paisId);

        return $this->success($departamentos, 'Departamentos obtenidos exitosamente');
    }

    public function municipiosByDepartamento(int $departamentoId): JsonResponse
    {
        $municipios = $this->ubicacionQueryService->getMunicipiosByDepartamento($departamentoId);

        return $this->success($municipios, 'Municipios obtenidos exitosamente');
    }
}
