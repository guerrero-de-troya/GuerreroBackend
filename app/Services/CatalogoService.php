<?php

namespace App\Services;

use App\Models\Parametro;
use App\Models\Tema;
use Illuminate\Database\Eloquent\Collection;

class CatalogoService
{
    public function getAllTemas(): Collection
    {
        return Tema::query()
            ->with('parametros')
            ->get();
    }

    public function getTemaByName(string $temaName): Tema
    {
        return Tema::where('name', $temaName)
            ->with('parametros')
            ->firstOrFail();
    }

    public function getParametrosByTema(string $temaName): Collection
    {
        $tema = Tema::where('name', $temaName)->firstOrFail();

        return $tema->parametros;
    }

    public function getParametroByTema(string $temaName, string $parametroName): Parametro
    {
        $tema = Tema::where('name', $temaName)->firstOrFail();
        $parametro = Parametro::where('name', $parametroName)->firstOrFail();

        return $tema->parametros()
            ->where('parametros.id', $parametro->id)
            ->firstOrFail();
    }
}
