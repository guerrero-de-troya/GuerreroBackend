<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Repositories\Contracts\ParametroTemaRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaBaseSeeder extends Seeder
{
    use WithoutModelEvents;

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
        $tipoDocumentoTemp = $parametroTemaRepository->findByNames('Tipo Documento', 'TEMP');
        $generoTemp = $parametroTemaRepository->findByNames('Genero', 'TEMP');
        $categoriaTemp = $parametroTemaRepository->findByNames('Categoria', 'TEMP');
        $ciudadTemp = $parametroTemaRepository->findByNames('Ciudad', 'TEMP');

        // Crear persona base del sistema
        Persona::create([
            'primer_nombre' => 'SYSTEM',
            'primer_apellido' => 'BASE',
            'id_tipo_documento' => $tipoDocumentoTemp->id,
            'numero_documento' => 'SYSTEM_BASE',
            'telefono' => 'SYSTEM_BASE',
            'edad' => 0,
            'id_genero' => $generoTemp->id,
            'id_categoria' => $categoriaTemp->id,
            'id_ciudad_origen' => $ciudadTemp->id,
            'eps' => 'SYSTEM',
            'is_system' => true,
        ]);

        $this->command->info('Persona base del sistema creada exitosamente.');
    }
}
