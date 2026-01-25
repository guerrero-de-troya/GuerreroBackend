<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;

class EmailVerificationService
{
    public function verify(User $user): void
    {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    public function validateHash(User $user, string $hash): bool
    {
        return hash_equals($hash, sha1($user->getEmailForVerification()));
    }

    public function isVerified(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }
}
