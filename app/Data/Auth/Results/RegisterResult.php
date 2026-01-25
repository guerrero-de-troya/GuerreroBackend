<?php

namespace App\Data\Auth\Results;

class RegisterResult extends AuthResultWithToken
{
    public static function emailAlreadyExists(): self
    {
        return new self(
            success: false,
            reason: 'email_already_exists'
        );
    }
}
