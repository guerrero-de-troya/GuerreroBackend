<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

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

        // Rate limiting adicional por usuario
        $key = 'send-verification:' . $user->id;
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return [
                'success' => false,
                'message' => "Demasiados intentos. Intenta nuevamente mas tarde.",
                'statusCode' => 429,
            ];
        }

        RateLimiter::hit($key, 3600); // 1 hora

        $user->sendEmailVerificationNotification();

        return [
            'success' => true,
            'message' => 'Email de verificación reenviado.',
            'statusCode' => 200,
        ];
    }
}
