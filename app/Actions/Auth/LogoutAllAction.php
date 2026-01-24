<?php

namespace App\Actions\Auth;

use App\Models\User;

class LogoutAllAction
{
    public function execute(User $user): array
    {
        $user->tokens()->delete();

        return [
            'success' => true,
            'message' => 'Cierre de sesión en todos los dispositivos exitoso',
            'statusCode' => 200,
        ];
    }
}
