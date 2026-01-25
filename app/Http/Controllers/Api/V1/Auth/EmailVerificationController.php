<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\SendEmailVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Auth\SendEmailVerificationHttpMapper;
use App\Http\Mappers\Auth\VerifyEmailHttpMapper;
use App\Http\Requests\VerifyEmailRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SendEmailVerificationAction $sendEmailVerificationAction,
        private readonly VerifyEmailAction $verifyEmailAction,
        private readonly SendEmailVerificationHttpMapper $sendMapper,
        private readonly VerifyEmailHttpMapper $verifyMapper
    ) {}

    public function send(Request $request): JsonResponse
    {
        $result = $this->sendEmailVerificationAction->execute($request->user());

        return $this->sendMapper->toResponse($result);
    }

    public function verify(VerifyEmailRequest $request): JsonResponse
    {
        $result = $this->verifyEmailAction->execute($request->toDto());

        return $this->verifyMapper->toResponse($result);
    }
}
