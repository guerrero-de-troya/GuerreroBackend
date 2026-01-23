<?php

namespace App\Actions\Auth;

use App\Models\User;

class SendEmailVerificationAction
{
    public function execute(User $user): array
    {
        if ($user->hasVerifiedEmail()) {
            return [
                'success' => false,
                'message' => 'El email ya ha sido verificado.',
                'statusCode' => 400,
            ];
        }

        $user->sendEmailVerificationNotification();

        return [
            'success' => true,
            'message' => 'Email de verificación enviado exitosamente.',
            'statusCode' => 200,
        ];
    }
}
