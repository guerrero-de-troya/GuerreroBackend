<?php

namespace App\Data\Auth\Results;

class ForgotPasswordResult
{
    public function __construct(
        public readonly bool $sent,
        public readonly string $reason
    ) {}

    public static function sent(): self
    {
        return new self(sent: true, reason: 'sent');
    }

    public static function throttled(): self
    {
        return new self(sent: false, reason: 'throttled');
    }

    public static function ignored(): self
    {
        return new self(sent: false, reason: 'ignored');
    }

    public static function error(): self
    {
        return new self(sent: false, reason: 'error');
    }
}
