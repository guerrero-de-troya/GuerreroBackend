<?php

namespace App\Repositories;

use App\Models\Departamento;
use App\Repositories\Contracts\DepartamentoRepositoryInterface;

class DepartamentoRepository extends BaseRepository implements DepartamentoRepositoryInterface
{
    protected function model(): string
    {
        return Departamento::class;
    }

    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()->with('pais')->orderBy('departamento')->get();
    }

    public function getByPaisId(int $paisId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()
            ->where('pais_id', $paisId)
            ->orderBy('departamento')
            ->get();
    }
}
