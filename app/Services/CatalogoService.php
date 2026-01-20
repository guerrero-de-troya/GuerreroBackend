<?php

namespace App\Services;

use App\Exceptions\TemaNotFoundException;
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
        $tema = Tema::where('name', $temaName)
            ->with('parametros')
            ->first();

        if ($tema === null) {
            throw new TemaNotFoundException($temaName);
        }

        return $tema;
    }

    public function getParametrosByTema(string $temaName): Collection
    {
        $tema = Tema::where('name', $temaName)->first();

        if ($tema === null) {
            throw new TemaNotFoundException($temaName);
        }

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
