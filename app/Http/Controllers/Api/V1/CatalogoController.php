<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Services\CatalogoService;
use Illuminate\Http\JsonResponse;

class CatalogoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly CatalogoService $catalogoService
    ) {}

    public function temas(): JsonResponse
    {
        $temas = $this->catalogoService->getAllTemas();

        return $this->success($temas, 'Temas obtenidos exitosamente');
    }

    public function parametrosPorTema(string $temaName): JsonResponse
    {
        $tema = $this->catalogoService->getTemaByName($temaName);

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
        $parametros = $this->catalogoService->getParametrosByTema($temaName);

        return $this->success($parametros, 'Parámetros obtenidos exitosamente');
    }
}
