<?php

namespace App\Data\Auth;

use App\Traits\NormalizesEmail;
use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ResetPasswordData extends Data
{
    use NormalizesEmail;

    public function __construct(
        public string $token,
        public string $email,
        public string $password,
        #[MapInputName('password_confirmation')]
        public string $passwordConfirmation,
    ) {}

    public static function fromRequest(array $data): static
    {
        $instance = new static(
            token: $data['token'] ?? '',
            email: '',
            password: $data['password'] ?? '',
            passwordConfirmation: $data['password_confirmation'] ?? ''
        );
        $instance->email = $instance->normalizeEmail($data['email'] ?? '');
        
        return $instance;
    }

    public static function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ];
    }
}
