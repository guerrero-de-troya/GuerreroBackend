<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Services\Query\CatalogoQueryService;
use Illuminate\Http\JsonResponse;

class CatalogoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly CatalogoQueryService $catalogoQueryService
    ) {}

    public function temas(): JsonResponse
    {
        $temas = $this->catalogoQueryService->getAllTemas();

        return $this->success($temas, 'Temas obtenidos exitosamente');
    }

    public function parametrosPorTema(string $temaName): JsonResponse
    {
        $tema = $this->catalogoQueryService->getTemaByName($temaName);

        return $this->success(
            [
                'tema' => $tema->name,
                'parametros' => $tema->parametros,
            ],
            'Parámetros obtenidos exitosamente'
        );
    }

    public function parametros(string $temaName): JsonResponse
    {
        $parametros = $this->catalogoQueryService->getParametrosByTema($temaName);

        return $this->success($parametros, 'Parámetros obtenidos exitosamente');
    }
}
