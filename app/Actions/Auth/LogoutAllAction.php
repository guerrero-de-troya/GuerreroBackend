<?php

namespace App\Actions\Auth;

use App\Data\Auth\Results\LogoutResult;
use App\Models\User;
use App\Services\Auth\TokenService;

class LogoutAllAction
{
    public function __construct(
        private readonly TokenService $tokenService
    ) {}

    public function execute(User $user): LogoutResult
    {
        $this->tokenService->revokeAll($user);

        return LogoutResult::success();
    }
}
