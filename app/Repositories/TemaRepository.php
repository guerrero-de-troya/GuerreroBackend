<?php

namespace App\Repositories;

use App\Models\Tema;
use App\Repositories\Contracts\TemaRepositoryInterface;

/**
 * Tema Repository
 */
class TemaRepository extends BaseRepository implements TemaRepositoryInterface
{
    protected function model(): string
    {
        return Tema::class;
    }

    /**
     * Buscar tema por nombre
     */
    public function findByName(string $name): ?Tema
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }
}
