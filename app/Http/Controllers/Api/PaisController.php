<?php

namespace App\Http\Controllers\Api;

use App\Services\UbicacionService;
use Illuminate\Http\JsonResponse;

class PaisController extends BaseController
{
    public function __construct(
        private readonly UbicacionService $ubicacionService
    ) {}

    /**
     * Obtener todos los países
     */
    public function index(): JsonResponse
    {
        try {
            $paises = $this->ubicacionService->getPaises();

            return $this->success($paises, 'Países obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al obtener países: '.$e->getMessage(), 500);
        }
    }
}
