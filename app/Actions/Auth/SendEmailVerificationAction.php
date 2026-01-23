<?php

namespace App\Actions\Auth;

use App\Models\User;

class SendEmailVerificationAction
{
    public function execute(User $user): array
    {
        if ($user->hasVerifiedEmail()) {
            return [
                'message' => 'El email ya ha sido verificado.',
                'success' => false,
                'statusCode' => 400,
            ];
        }

        $user->sendEmailVerificationNotification();

        return [
            'message' => 'Email de verificación enviado exitosamente.',
            'success' => true,
            'statusCode' => 200,
        ];
    }
}
