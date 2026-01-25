<?php

namespace App\Data\Auth\Results;

class LoginResult extends AuthResultWithToken
{
    public static function invalidCredentials(): self
    {
        return new self(
            success: false,
            reason: 'invalid_credentials'
        );
    }

    public static function emailNotVerified(): self
    {
        return new self(
            success: false,
            reason: 'email_not_verified'
        );
    }
}
