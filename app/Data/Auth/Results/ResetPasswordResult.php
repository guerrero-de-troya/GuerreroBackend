<?php

namespace App\Data\Auth\Results;

class ResetPasswordResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $reason = 'success'
    ) {}

    public static function success(): self
    {
        return new self(success: true, reason: 'password_reset');
    }

    public static function invalidToken(): self
    {
        return new self(success: false, reason: 'invalid_token');
    }
}
