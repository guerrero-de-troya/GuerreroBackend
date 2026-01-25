<?php

namespace App\Data\Auth\Results;

class SendEmailVerificationResult
{
    public function __construct(
        public readonly bool $sent,
        public readonly string $reason
    ) {}

    public static function sent(): self
    {
        return new self(sent: true, reason: 'sent');
    }

    public static function alreadyVerified(): self
    {
        return new self(sent: false, reason: 'already_verified');
    }

    public static function throttled(): self
    {
        return new self(sent: false, reason: 'throttled');
    }
}
