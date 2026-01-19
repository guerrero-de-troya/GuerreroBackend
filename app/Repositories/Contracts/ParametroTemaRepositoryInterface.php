<?php

namespace App\Repositories\Contracts;

use App\Models\ParametroTema;

/**
 * ParametroTema Repository Interface
 */
interface ParametroTemaRepositoryInterface extends RepositoryInterface
{
    /**
     * Buscar ParametroTema por nombres de tema y parámetro
     *
     * @param  string  $temaName
     * @param  string  $parametroName
     * @return ParametroTema
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByNames(string $temaName, string $parametroName): ParametroTema;
}