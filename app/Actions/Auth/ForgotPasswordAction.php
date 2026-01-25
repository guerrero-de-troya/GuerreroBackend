<?php

namespace App\Actions\Auth;

use App\Data\Auth\ForgotPasswordData;
use App\Data\Auth\Results\ForgotPasswordResult;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Password;

class ForgotPasswordAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(ForgotPasswordData $data): ForgotPasswordResult
    {
        $email = strtolower($data->email);

        $user = $this->userRepository->findByEmail($email);
        
        if (! $user || ! $user->hasVerifiedEmail()) {
            return ForgotPasswordResult::ignored();
        }

        $status = Password::sendResetLink(['email' => $email]);

        return match ($status) {
            Password::RESET_LINK_SENT => ForgotPasswordResult::sent(),
            Password::RESET_THROTTLED => ForgotPasswordResult::throttled(),
            default => ForgotPasswordResult::error(),
        };
    }
}