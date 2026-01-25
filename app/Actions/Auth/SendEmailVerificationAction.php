<?php

namespace App\Actions\Auth;

use App\Data\Auth\Results\SendEmailVerificationResult;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class SendEmailVerificationAction
{
    public function execute(User $user): SendEmailVerificationResult
    {
        if ($user->hasVerifiedEmail()) {
            return SendEmailVerificationResult::alreadyVerified();
        }

        // Rate limiting adicional por usuario
        $key = 'send-verification:' . $user->id;
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return SendEmailVerificationResult::throttled();
        }

        RateLimiter::hit($key, 3600); // 1 hora

        $user->sendEmailVerificationNotification();

        return SendEmailVerificationResult::sent();
    }
}
