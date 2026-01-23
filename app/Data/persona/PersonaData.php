<?php

namespace App\Data\Persona;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class PersonaData extends Data
{
    public function __construct(
        public int $id,
        public string $primerNombre,
        public ?string $segundoNombre,
        public string $primerApellido,
        public ?string $segundoApellido,
        public int $tipoDocumentoId,
        public string $numeroDocumento,
        public string $telefono,
        public int $edad,
        public int $generoId,
        public ?int $nivelId,
        public ?string $camisa,
        public ?int $tallaId,
        public ?int $epsId,
        public ?int $paisId,
        public ?int $departamentoId,
        public ?int $municipioId,
        public string $createdAt,
        public string $updatedAt,
    ) {}
}
