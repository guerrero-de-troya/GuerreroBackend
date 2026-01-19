<?php

namespace App\Repositories\Contracts;

use App\Models\Parametro;

/**
 * Parametro Repository Interface
 */
interface ParametroRepositoryInterface extends RepositoryInterface
{
    /**
     * Buscar parámetro por nombre
     */
    public function findByName(string $name): ?Parametro;
}
