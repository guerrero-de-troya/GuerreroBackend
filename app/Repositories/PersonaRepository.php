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
     * Obtener la persona base del sistema
     *
     * La persona base del sistema se usa como placeholder para mantener
     * integridad referencial. Los usuarios nuevos apuntan a esta persona
     * hasta que crean su perfil real.
     *
     * NOTA: La persona base debe ser creada mediante el seeder PersonaBaseSeeder
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no existe la persona base
     */
    public function getSystemPersona(): Persona
    {
        return $this->model->newQuery()
            ->where('is_system', true)
            ->firstOrFail();
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
