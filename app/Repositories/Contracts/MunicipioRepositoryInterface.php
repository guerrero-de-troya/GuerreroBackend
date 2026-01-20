<?php

namespace App\Repositories\Contracts;

use App\Models\Municipio;

interface MunicipioRepositoryInterface extends RepositoryInterface
{
    /**
     * Obtener todos los municipios ordenados
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Municipio>
     */
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Obtener municipios por departamento
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Municipio>
     */
    public function getByDepartamentoId(int $departamentoId): \Illuminate\Database\Eloquent\Collection;
}
