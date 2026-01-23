<?php

namespace App\Services\Query;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;
use Illuminate\Database\Eloquent\Collection;

class UbicacionQueryService
{
    public function getPaises(): Collection
    {
        return Pais::query()->orderBy('pais')->get();
    }

    public function getDepartamentos(): Collection
    {
        return Departamento::query()
            ->with('pais')
            ->orderBy('departamento')
            ->get();
    }

    public function getDepartamentosByPais(int $paisId): Collection
    {
        return Departamento::query()
            ->where('pais_id', $paisId)
            ->orderBy('departamento')
            ->get();
    }

    public function getMunicipios(): Collection
    {
        return Municipio::query()
            ->with('departamento')
            ->orderBy('municipio')
            ->get();
    }

    public function getMunicipiosByDepartamento(int $departamentoId): Collection
    {
        return Municipio::query()
            ->where('departamento_id', $departamentoId)
            ->orderBy('municipio')
            ->get();
    }
}
