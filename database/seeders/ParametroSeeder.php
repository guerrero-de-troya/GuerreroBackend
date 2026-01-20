<?php

namespace Database\Seeders;

use App\Models\Parametro;
use App\Models\Tema;
use Illuminate\Database\Seeder;

class ParametroSeeder extends Seeder
{
    private const PARAMETROS_POR_TEMA = [
        'GENERO' => [
            'MASCULINO',
            'FEMENINO',
            'TEMP',
        ],
        'TALLA' => [
            'XS',
            'S',
            'M',
            'L',
            'XL',
            'XXL',
            '3XL',
            '4XL',
        ],
        'TIPO DOCUMENTO' => [
            'CÉDULA DE CIUDADANÍA',
            'TARJETA DE IDENTIDAD',
            'REGISTRO CIVIL',
            'CÉDULA DE EXTRANJERÍA',
            'PASAPORTE',
            'PERMISO POR PROTECCIÓN TEMPORAL',
            'PERMISO ESPECIAL DE PERMANENCIA',
            'TEMP',
        ],
        'EPS' => [
            'COOSALUD',
            'NUEVA EPS',
            'MUTUAL SER',
            'SALUD MÍA',
            'ALIANSALUD',
            'SALUD TOTAL',
            'SANITAS',
            'SURA',
            'FAMISANAR',
            'SOS',
            'COMFENALCO VALLE',
            'COMPENSAR',
            'EPM',
            'CAJACOPI ATLÁNTICO',
            'CAPRESOCA',
            'COMFACHOCÓ',
            'COMFAORIENTE',
            'EPS FAMILIAR DE COLOMBIA',
            'ASMET SALUD',
            'EMSSANAR',
            'CAPITAL SALUD',
            'SAVIA SALUD',
            'DUSAKAWI EPSI',
            'ASOCIACIÓN INDÍGENA DEL CAUCA EPSI',
            'ANAS WAYUU EPSI',
            'MALLAMAS EPSI',
            'PIJAOS SALUD EPSI',
            'TEMP',
        ],
        'NIVEL' => [
            'PRINCIPIANTE',
            'ELITE',
            'TEMP',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::PARAMETROS_POR_TEMA as $temaNombre => $parametros) {
            $tema = Tema::where('name', $temaNombre)->first();

            if (! $tema) {
                continue;
            }

            $parametroIds = [];

            foreach ($parametros as $parametroNombre) {
                $parametro = Parametro::firstOrCreate(
                    ['name' => $parametroNombre],
                    ['name' => $parametroNombre]
                );

                $parametroIds[] = $parametro->id;
            }

            $tema->parametros()->syncWithoutDetaching($parametroIds);
        }
    }
}
