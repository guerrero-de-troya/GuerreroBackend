<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ForgotPasswordAction $forgotPasswordAction,
        private readonly ResetPasswordAction $resetPasswordAction
    ) {}

    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->forgotPasswordAction->execute($request->toDto());

        return $this->respond($result['success'], $result);
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->resetPasswordAction->execute($request->toDto());

        return $this->respond($result['success'], $result);
    }
}
