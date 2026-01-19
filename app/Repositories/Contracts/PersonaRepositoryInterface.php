<?php

namespace App\Repositories\Contracts;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Collection;

/**
 * Persona Repository Interface
 *
 * Define métodos específicos para el repositorio de personas.
 */
interface PersonaRepositoryInterface extends RepositoryInterface
{
    /**
     * Obtener o crear la persona base del sistema
     */
    public function getOrCreateSystemPersona(): Persona;

    /**
     * Buscar persona por ID con relaciones cargadas
     *
     * @param  array<string>  $relations
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFailWithRelations(int|string $id, array $relations = []): Persona;

    /**
     * Obtener todas las personas con relaciones cargadas
     *
     * @param  array<string>  $relations
     * @return Collection<int, Persona>
     */
    public function allWithRelations(array $relations = []): Collection;

    /**
     * Verificar si existe una persona por número de documento
     */
    public function existsByNumeroDocumento(string $numeroDocumento): bool;

    /**
     * Verificar si existe una persona por teléfono
     */
    public function existsByTelefono(string $telefono): bool;
}
