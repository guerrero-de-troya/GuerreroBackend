<?php

namespace App\Data\Persona;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ProfileData extends Data
{
    public function __construct(
        public bool $hasPersona,
        public ?PersonaData $persona
    ) {}
}
