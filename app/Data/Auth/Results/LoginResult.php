<?php

namespace App\Data\Auth\Results;

class LoginResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?object $user = null,
        public readonly ?string $token = null,
        public readonly string $reason = 'success'
    ) {}

    public static function success(object $user, string $token): self
    {
        return new self(
            success: true,
            user: $user,
            token: $token,
            reason: 'success'
        );
    }

    public static function invalidCredentials(): self
    {
        return new self(
            success: false,
            reason: 'invalid_credentials'
        );
    }
}
