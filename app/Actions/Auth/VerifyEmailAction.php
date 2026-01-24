<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmailAction
{
    public function execute(User $user): array
    {
        if ($user->hasVerifiedEmail()) {
            return [
                'success' => true,
                'message' => 'El email ya fue verificado.',
                'statusCode' => 200,
            ];
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return [
            'success' => true,
            'message' => 'Email verificado exitosamente.',
            'statusCode' => 200,
        ];
    }
}
