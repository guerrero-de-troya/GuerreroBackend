<?php

namespace App\Repositories;

use App\Models\Pais;
use App\Repositories\Contracts\PaisRepositoryInterface;

class PaisRepository extends BaseRepository implements PaisRepositoryInterface
{
    protected function model(): string
    {
        return Pais::class;
    }

    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()->orderBy('pais')->get();
    }
}
