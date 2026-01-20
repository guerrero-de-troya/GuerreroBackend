<?php

namespace App\Repositories\Contracts;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Collection;

interface PersonaRepositoryInterface extends RepositoryInterface
{
    public function getSystemPersona(): Persona;

    public function findOrFailWithRelations(int|string $id, array $relations = []): Persona;

    public function allWithRelations(array $relations = []): Collection;

    public function existsByNumeroDocumento(string $numeroDocumento): bool;

    public function existsByTelefono(string $telefono): bool;
}
