<?php

namespace App\Data\Auth\Results;

abstract class AuthResultWithToken
{
    public function __construct(
        public readonly bool $success,
        public readonly ?object $user = null,
        public readonly ?string $token = null,
        public readonly string $reason = 'success'
    ) {}

    public static function success(object $user, string $token): static
    {
        return new static(
            success: true,
            user: $user,
            token: $token,
            reason: 'success'
        );
    }
}
