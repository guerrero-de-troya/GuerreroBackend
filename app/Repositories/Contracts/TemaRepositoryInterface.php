<?php

namespace App\Repositories\Contracts;

use App\Models\Tema;

/**
 * Tema Repository Interface
 */
interface TemaRepositoryInterface extends RepositoryInterface
{
    /**
     * Buscar tema por nombre
     */
    public function findByName(string $name): ?Tema;
}
