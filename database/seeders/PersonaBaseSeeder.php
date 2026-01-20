<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Repositories\Contracts\ParametroTemaRepositoryInterface;
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

        // Resolver el repositorio mediante el contenedor
        $parametroTemaRepository = app(ParametroTemaRepositoryInterface::class);

        // Obtener ParametroTema por nombres
        $tipoDocumentoTemp = $parametroTemaRepository->findByNames('TIPO DOCUMENTO', 'TEMP');
        $generoTemp = $parametroTemaRepository->findByNames('GENERO', 'TEMP');
        $categoriaTemp = $parametroTemaRepository->findByNames('CATEGORIA', 'TEMP');
        $ciudadTemp = $parametroTemaRepository->findByNames('CIUDAD', 'TEMP');
        $epsTemp = $parametroTemaRepository->findByNames('EPS', 'TEMP');

        // Crear persona base del sistema
        Persona::create([
            'primer_nombre' => self::SYSTEM_PERSONA_NAME,
            'primer_apellido' => self::SYSTEM_PERSONA_NAME,
            'id_tipo_documento' => $tipoDocumentoTemp->id,
            'numero_documento' => self::SYSTEM_PERSONA_NAME,
            'telefono' => self::SYSTEM_PERSONA_NAME,
            'edad' => 0,
            'id_genero' => $generoTemp->id,
            'id_categoria' => $categoriaTemp->id,
            'id_ciudad_origen' => $ciudadTemp->id,
            'id_eps' => $epsTemp->id,
            'departamento_id' => null,
            'municipio_id' => null,
            'is_system' => true,
        ]);

        $this->command->info('Persona base del sistema creada exitosamente.');
    }
}
