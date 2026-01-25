<?php

namespace App\Actions\Auth;

use App\Data\Auth\Results\VerifyEmailResult;
use App\Data\Auth\VerifyEmailData;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Auth\EmailVerificationService;

class VerifyEmailAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EmailVerificationService $emailVerificationService
    ) {}

    public function execute(VerifyEmailData $data): VerifyEmailResult
    {
        $user = $this->userRepository->find($data->id);

        if (! $user) {
            return VerifyEmailResult::userNotFound();
        }

        // Validar hash del email
        if (! $this->emailVerificationService->validateHash($user, $data->hash)) {
            return VerifyEmailResult::invalidHash();
        }

        if ($this->emailVerificationService->isVerified($user)) {
            return VerifyEmailResult::alreadyVerified();
        }

        $this->emailVerificationService->verify($user);

        return VerifyEmailResult::success();
    }
}
