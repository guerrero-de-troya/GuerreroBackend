<?php

namespace App\Repositories;

use App\Models\Parametro;
use App\Repositories\Contracts\ParametroRepositoryInterface;

/**
 * Parametro Repository
 */
class ParametroRepository extends BaseRepository implements ParametroRepositoryInterface
{
    protected function model(): string
    {
        return Parametro::class;
    }

    /**
     * Buscar parámetro por nombre
     */
    public function findByName(string $name): ?Parametro
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }
}
