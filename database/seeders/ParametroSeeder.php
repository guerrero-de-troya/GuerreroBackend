<?php

namespace Database\Seeders;

use App\Models\Parametro;
use Illuminate\Database\Seeder;

class ParametroSeeder extends Seeder
{
    private const PARAMETROS = [
        'MASCULINO',
        'FEMENINO',
        'XS',
        'S',
        'M',
        'L',
        'XL',
        'XXL',
        '3XL',
        '4XL',
        'CÉDULA DE CIUDADANÍA',
        'TARJETA DE IDENTIDAD',
        'REGISTRO CIVIL',
        'CÉDULA DE EXTRANJERÍA',
        'PASAPORTE',
        'PERMISO POR PROTECCIÓN TEMPORAL',
        'PERMISO ESPECIAL DE PERMANENCIA',
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
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::PARAMETROS as $parametroNombre) {
            Parametro::firstOrCreate(
                ['name' => $parametroNombre],
                ['name' => $parametroNombre]
            );
        }
    }
}
