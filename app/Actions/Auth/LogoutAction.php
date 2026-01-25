<?php

namespace App\Actions\Auth;

use App\Data\Auth\Results\LogoutResult;
use App\Models\User;
use App\Services\Auth\TokenService;

class LogoutAction
{
    public function __construct(
        private readonly TokenService $tokenService
    ) {}

    public function execute(?User $user): LogoutResult
    {
        if ($user !== null) {
            $this->tokenService->revokeCurrent($user);
        }

        return LogoutResult::success();
    }
}
