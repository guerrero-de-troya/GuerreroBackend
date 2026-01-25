<?php

namespace App\Data\Auth\Results;

class VerifyEmailResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $reason = 'success'
    ) {}

    public static function success(): self
    {
        return new self(success: true, reason: 'verified');
    }

    public static function alreadyVerified(): self
    {
        return new self(success: true, reason: 'already_verified');
    }

    public static function userNotFound(): self
    {
        return new self(success: false, reason: 'user_not_found');
    }

    public static function invalidHash(): self
    {
        return new self(success: false, reason: 'invalid_hash');
    }
}
