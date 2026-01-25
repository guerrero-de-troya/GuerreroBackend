<?php

namespace App\Services\Auth;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class TokenService
{
    
    public function create(User $user, string $tokenName = 'auth-token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function limitTokens(User $user, int $maxTokens = 5): void
    {
        while ($user->tokens()->count() >= $maxTokens) {
            $user->tokens()->oldest()->first()?->delete();
        }
    }

    public function revokeCurrent(User $user): void
    {
        $token = $user->currentAccessToken();
        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }
    }

    public function revokeAll(User $user): void
    {
        $user->tokens()->delete();
    }

    public function count(User $user): int
    {
        return $user->tokens()->count();
    }
}
