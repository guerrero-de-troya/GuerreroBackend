<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\LogoutAllAction;
use App\Actions\Auth\RegisterAction;
use App\Data\User\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly RegisterAction $registerAction,
        private readonly LoginAction $loginAction,
        private readonly LogoutAction $logoutAction,
        private readonly LogoutAllAction $logoutAllAction
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->registerAction->execute($request->toDto());

        return $this->respond($result['success'], $result);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->loginAction->execute($request->toDto());

        return $this->respond($result['success'], $result);
    }

    public function logout(Request $request): JsonResponse
    {
        $result = $this->logoutAction->execute($request->user());

        return $this->respond($result['success'], $result);
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $result = $this->logoutAllAction->execute($request->user()->id);

        return $this->respond($result['success'], $result);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load('persona');

        return $this->success(
            UserData::from($user),
            'Usuario obtenido exitosamente'
        );
    }
}
