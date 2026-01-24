<?php

namespace App\Actions\Auth;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutAction
{
    public function execute(User $user): array
    {
        $token = $user->currentAccessToken();
        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return [
            'success' => true,
            'message' => 'Cierre de sesión exitoso',
            'statusCode' => 200,
        ];
    }
}
