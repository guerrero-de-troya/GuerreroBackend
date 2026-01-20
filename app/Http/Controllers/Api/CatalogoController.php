<?php

namespace App\Http\Controllers\Api;

use App\Services\CatalogoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CatalogoController extends BaseController
{
    public function __construct(
        private readonly CatalogoService $catalogoService
    ) {}

    public function temas(): JsonResponse
    {
        try {
            $temas = $this->catalogoService->getAllTemas();

            return $this->success($temas, 'Temas obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener temas: '.$e->getMessage(), 500);
        }
    }

    public function parametrosPorTema(string $temaName): JsonResponse
    {
        try {
            $tema = $this->catalogoService->getTemaByName($temaName);

            return $this->success(
                [
                    'tema' => $tema->name,
                    'parametros' => $tema->parametros,
                ],
                'Parámetros obtenidos exitosamente'
            );
        } catch (ModelNotFoundException $e) {
            return $this->error("Tema '{$temaName}' no encontrado", 404);
        } catch (\Exception $e) {
            return $this->error('Error al obtener parámetros: '.$e->getMessage(), 500);
        }
    }

    public function parametros(string $temaName): JsonResponse
    {
        try {
            $parametros = $this->catalogoService->getParametrosByTema($temaName);

            return $this->success($parametros, 'Parámetros obtenidos exitosamente');
        } catch (ModelNotFoundException $e) {
            return $this->error("Tema '{$temaName}' no encontrado", 404);
        } catch (\Exception $e) {
            return $this->error('Error al obtener parámetros: '.$e->getMessage(), 500);
        }
    }
}
