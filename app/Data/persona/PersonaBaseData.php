<?php

namespace App\Data\Persona;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
abstract class PersonaBaseData extends Data
{
    public function __construct(
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
    ) {}

    public static function baseRules(): array
    {
        return [
            'primer_nombre' => ['required', 'string', 'max:255'],
            'segundo_nombre' => ['nullable', 'string', 'max:255'],
            'primer_apellido' => ['required', 'string', 'max:255'],
            'segundo_apellido' => ['nullable', 'string', 'max:255'],
            'tipo_documento_id' => ['required', 'exists:parametros,id'],
            'numero_documento' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'integer', 'min:0', 'max:150'],
            'genero_id' => ['required', 'exists:parametros,id'],
            'nivel_id' => ['nullable', 'exists:parametros,id'],
            'camisa' => ['nullable', 'string', 'max:255'],
            'talla_id' => ['nullable', 'exists:parametros,id'],
            'eps_id' => ['nullable', 'exists:parametros,id'],
            'pais_id' => ['nullable', 'exists:paises,id'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'municipio_id' => ['nullable', 'exists:municipios,id'],
        ];
    }    
}
