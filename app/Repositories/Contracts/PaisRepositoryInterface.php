<?php

namespace App\Repositories\Contracts;

use App\Models\Pais;

interface PaisRepositoryInterface extends RepositoryInterface
{
    /**
     * Obtener todos los países ordenados
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Pais>
     */
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection;
}
