<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ForgotPasswordData extends Data
{
    public function __construct(
        public string $email,
    ) {}

    public static function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }
}
