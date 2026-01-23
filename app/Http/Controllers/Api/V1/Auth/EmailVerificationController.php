<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\SendEmailVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SendEmailVerificationAction $sendEmailVerificationAction,
        private readonly VerifyEmailAction $verifyEmailAction
    ) {}

    public function send(Request $request): JsonResponse
    {
        $result = $this->sendEmailVerificationAction->execute($request->user());

        return $result['success']
            ? $this->success(null, $result['message'])
            : $this->error($result['message'], 400);
    }

    public function verify(Request $request): JsonResponse
    {
        $userId = (int) $request->route('id');
        $result = $this->verifyEmailAction->execute($userId);

        return $result['success']
            ? $this->success(null, $result['message'])
            : $this->error($result['message'], 400);
    }
}
