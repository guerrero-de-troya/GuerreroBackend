<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\Contracts\ParametroTemaRepositoryInterface;
use App\Repositories\Contracts\PersonaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Persona Repository
 * Implementación del repositorio para personas.
 */
class PersonaRepository extends BaseRepository implements PersonaRepositoryInterface
{
    public function __construct(
        private readonly ParametroTemaRepositoryInterface $parametroTemaRepository
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
        return Persona::class;
    }

    /**
     * Obtener o crear la persona base del sistema
     *
     * La persona base del sistema se usa como placeholder para mantener
     * integridad referencial. Los usuarios nuevos apuntan a esta persona
     * hasta que crean su perfil real.
     *
     * NOTA: Requiere que existan registros en temas y parametros con los nombres:
     * - Tema: 'Tipo Documento' con Parametro: 'TEMP'
     * - Tema: 'Genero' con Parametro: 'TEMP'
     * - Tema: 'Categoria' con Parametro: 'TEMP'
     * - Tema: 'Ciudad' con Parametro: 'TEMP'
     */
    public function getOrCreateSystemPersona(): Persona
    {
        // Intentar obtener la persona base del sistema
        $systemPersona = $this->model->newQuery()
            ->where('is_system', true)
            ->first();

        if ($systemPersona) {
            return $systemPersona;
        }

        // Obtener ParametroTema por nombres 
        $tipoDocumentoTemp = $this->parametroTemaRepository->findByNames('Tipo Documento', 'TEMP');
        $generoTemp = $this->parametroTemaRepository->findByNames('Genero', 'TEMP');
        $categoriaTemp = $this->parametroTemaRepository->findByNames('Categoria', 'TEMP');
        $ciudadTemp = $this->parametroTemaRepository->findByNames('Ciudad', 'TEMP');

        // Crear persona base del sistema
        $systemData = [
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
        ];

        return $this->create($systemData);
    }

    /**
     * Buscar persona por ID con relaciones cargadas
     *
     * @param  array<string>  $relations
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFailWithRelations(int|string $id, array $relations = []): Persona
    {
        $query = $this->model->newQuery();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->findOrFail($id);
    }

    /**
     * Obtener todas las personas con relaciones cargadas
     *
     * @param  array<string>  $relations
     * @return \Illuminate\Database\Eloquent\Collection<int, Persona>
     */
    public function allWithRelations(array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->get();
    }

    /**
     * Verificar si existe una persona por número de documento
     */
    public function existsByNumeroDocumento(string $numeroDocumento): bool
    {
        return $this->model->newQuery()
            ->where('numero_documento', strtoupper($numeroDocumento))
            ->exists();
    }

    /**
     * Verificar si existe una persona por teléfono
     */
    public function existsByTelefono(string $telefono): bool
    {
        return $this->model->newQuery()
            ->where('telefono', strtoupper($telefono))
            ->exists();
    }
}
