<?php

namespace App\Repositories\Contracts;

use App\Models\Departamento;

interface DepartamentoRepositoryInterface extends RepositoryInterface
{
    /**
     * Obtener todos los departamentos ordenados
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Departamento>
     */
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Obtener departamentos por país
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Departamento>
     */
    public function getByPaisId(int $paisId): \Illuminate\Database\Eloquent\Collection;
}
