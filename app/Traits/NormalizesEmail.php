<?php

namespace App\Traits;

trait NormalizesEmail
{
    protected function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }
}
