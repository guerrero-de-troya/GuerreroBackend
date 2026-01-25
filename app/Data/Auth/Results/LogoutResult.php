<?php

namespace App\Data\Auth\Results;

class LogoutResult
{
    public function __construct(
        public readonly bool $success = true,
        public readonly string $reason = 'logged_out'
    ) {}

    public static function success(): self
    {
        return new self();
    }
}
