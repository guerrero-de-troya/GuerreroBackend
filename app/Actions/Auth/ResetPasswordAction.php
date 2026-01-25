<?php

namespace App\Actions\Auth;

use App\Data\Auth\ResetPasswordData;
use App\Data\Auth\Results\ResetPasswordResult;
use App\Services\Auth\PasswordService;
use App\Services\Auth\TokenService;
use Illuminate\Support\Facades\Password;

class ResetPasswordAction
{
    public function __construct(
        private readonly PasswordService $passwordService,
        private readonly TokenService $tokenService
    ) {}

    public function execute(ResetPasswordData $data): ResetPasswordResult
    {
        $status = Password::reset(
            [
                'email' => $data->email,
                'password' => $data->password,
                'password_confirmation' => $data->passwordConfirmation,
                'token' => $data->token,
            ],
            function ($user, $password) {
                $this->passwordService->updatePassword($user, $password);
                $this->tokenService->revokeAll($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? ResetPasswordResult::success()
            : ResetPasswordResult::invalidToken();
    }
}
