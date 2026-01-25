<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterData;
use App\Data\Auth\Results\RegisterResult;
use App\Data\User\UserData;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Auth\PasswordService;
use App\Services\Auth\TokenService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RegisterAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordService $passwordService,
        private readonly TokenService $tokenService
    ) {}

    public function execute(RegisterData $data): RegisterResult
    {
        if ($this->userRepository->existsByEmail($data->email)) {
            return RegisterResult::emailAlreadyExists();
        }

        $user = DB::transaction(function () use ($data) {
            $user = $this->userRepository->create([
                'email' => $data->email,
                'password' => $this->passwordService->hash($data->password),
                'persona_id' => null,
            ]);

            $user = $user->fresh();
            $user->assignRole('usuario');

            return $user;
        });

        event(new Registered($user));

        $token = $this->tokenService->create($user);

        return RegisterResult::success(UserData::from($user), $token);
    }
}
