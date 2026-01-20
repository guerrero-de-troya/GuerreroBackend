<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Services\CatalogoService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaBaseSeeder extends Seeder
{
    use WithoutModelEvents;

    private const SYSTEM_PERSONA_NAME = 'BASE';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe la persona base del sistema
        $systemPersona = Persona::where('is_system', true)->first();

        if ($systemPersona) {
            $this->command->info('La persona base del sistema ya existe.');

            return;
        }

        // Obtener parámetros por nombres de tema y parámetro usando el service
        $catalogoService = app(CatalogoService::class);

        $tipoDocumentoTemp = $catalogoService->getParametroByTema('TIPO DOCUMENTO', 'TEMP');
        $generoTemp = $catalogoService->getParametroByTema('GENERO', 'TEMP');
        $nivelTemp = $catalogoService->getParametroByTema('NIVEL', 'TEMP');
        $epsTemp = $catalogoService->getParametroByTema('EPS', 'TEMP');

        // Crear persona base del sistema
        Persona::create([
            'primer_nombre' => self::SYSTEM_PERSONA_NAME,
            'primer_apellido' => self::SYSTEM_PERSONA_NAME,
            'tipo_documento_id' => $tipoDocumentoTemp->id,
            'numero_documento' => self::SYSTEM_PERSONA_NAME,
            'telefono' => self::SYSTEM_PERSONA_NAME,
            'edad' => 0,
            'genero_id' => $generoTemp->id,
            'nivel_id' => $nivelTemp->id,
            'eps_id' => $epsTemp->id,
            'pais_id' => null,
            'departamento_id' => null,
            'municipio_id' => null,
            'is_system' => true,
        ]);

        $this->command->info('Persona base del sistema creada exitosamente.');
    }
}
