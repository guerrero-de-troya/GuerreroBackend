<?php

namespace App\Repositories;

use App\Models\ParametroTema;
use App\Repositories\Contracts\ParametroRepositoryInterface;
use App\Repositories\Contracts\ParametroTemaRepositoryInterface;
use App\Repositories\Contracts\TemaRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * ParametroTema Repository
 */
class ParametroTemaRepository extends BaseRepository implements ParametroTemaRepositoryInterface
{
    public function __construct(
        private readonly TemaRepositoryInterface $temaRepository,
        private readonly ParametroRepositoryInterface $parametroRepository
    ) {
        parent::__construct();
    }

    /**
     * Obtener el nombre de la clase del modelo
     *
     * @return class-string<Model>
     */
    protected function model(): string
    {
        return ParametroTema::class;
    }

    /**
     * Buscar ParametroTema por nombres de tema y parámetro
     *
     * @param  string  $temaName
     * @param  string  $parametroName
     * @return ParametroTema
     * @throws ModelNotFoundException
     */
    public function findByNames(string $temaName, string $parametroName): ParametroTema
    {
        // Buscar tema por nombre
        $tema = $this->temaRepository->findByName($temaName);
        if (! $tema) {
            throw new ModelNotFoundException("Tema '{$temaName}' no encontrado");
        }

        // Buscar parámetro por nombre
        $parametro = $this->parametroRepository->findByName($parametroName);
        if (! $parametro) {
            throw new ModelNotFoundException("Parámetro '{$parametroName}' no encontrado");
        }

        // Buscar ParametroTema que relacione ambos
        return $this->model->newQuery()
            ->where('tema_id', $tema->id)
            ->where('parametro_id', $parametro->id)
            ->firstOrFail();
    }
}