<?php

namespace App\Services;

use App\Repositories\Contracts\DepartamentoRepositoryInterface;
use App\Repositories\Contracts\MunicipioRepositoryInterface;
use App\Repositories\Contracts\PaisRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UbicacionService
{
    public function __construct(
        private readonly PaisRepositoryInterface $paisRepository,
        private readonly DepartamentoRepositoryInterface $departamentoRepository,
        private readonly MunicipioRepositoryInterface $municipioRepository
    ) {}

    /**
     * Obtener todos los países
     *
     * @return Collection<int, \App\Models\Pais>
     */
    public function getPaises(): Collection
    {
        return $this->paisRepository->getAllOrdered();
    }

    /**
     * Obtener todos los departamentos
     *
     * @return Collection<int, \App\Models\Departamento>
     */
    public function getDepartamentos(): Collection
    {
        return $this->departamentoRepository->getAllOrdered();
    }

    /**
     * Obtener departamentos por país
     *
     * @return Collection<int, \App\Models\Departamento>
     */
    public function getDepartamentosByPais(int $paisId): Collection
    {
        return $this->departamentoRepository->getByPaisId($paisId);
    }

    /**
     * Obtener todos los municipios
     *
     * @return Collection<int, \App\Models\Municipio>
     */
    public function getMunicipios(): Collection
    {
        return $this->municipioRepository->getAllOrdered();
    }

    /**
     * Obtener municipios por departamento
     *
     * @return Collection<int, \App\Models\Municipio>
     */
    public function getMunicipiosByDepartamento(int $departamentoId): Collection
    {
        return $this->municipioRepository->getByDepartamentoId($departamentoId);
    }
}
