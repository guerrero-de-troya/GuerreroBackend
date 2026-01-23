<?php

namespace App\Data\User;

use App\Data\Persona\PersonaData;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $email,
        public ?string $emailVerifiedAt,
        public ?int $personaId,
        public ?PersonaData $persona,
        public string $createdAt,
        public string $updatedAt,
    ) {}
}
