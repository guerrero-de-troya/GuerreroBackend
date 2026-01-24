<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class VerifyEmailData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $hash
    ) {}

    public static function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:users,id'],
            'hash' => ['required', 'string'],
        ];
    }
}
