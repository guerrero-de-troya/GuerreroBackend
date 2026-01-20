<?php

namespace App\Repositories;

use App\Models\Municipio;
use App\Repositories\Contracts\MunicipioRepositoryInterface;

class MunicipioRepository extends BaseRepository implements MunicipioRepositoryInterface
{
    protected function model(): string
    {
        return Municipio::class;
    }

    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()->with('departamento')->orderBy('municipio')->get();
    }

    public function getByDepartamentoId(int $departamentoId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()
            ->where('departamento_id', $departamentoId)
            ->orderBy('municipio')
            ->get();
    }
}
