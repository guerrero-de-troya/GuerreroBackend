<?php

namespace App\Data\Auth;

use App\Traits\NormalizesEmail;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ForgotPasswordData extends Data
{
    use NormalizesEmail;

    public function __construct(
        public string $email,
    ) {}

    public static function fromRequest(array $data): static
    {
        $instance = new static(email: '');
        $instance->email = $instance->normalizeEmail($data['email'] ?? '');
        
        return $instance;
    }

    public static function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }
}
