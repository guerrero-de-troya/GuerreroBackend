<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\User\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return $this->created(
            [
                'user' => UserData::from($result['user']),
                'token' => $result['token'],
            ],
            'Usuario registrado exitosamente. Por favor verifica tu email.'
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->validated()['email'],
            $request->validated()['password']
        );

        return $this->success(
            [
                'user' => UserData::from($result['user']),
                'token' => $result['token'],
            ],
            'Sesión iniciada exitosamente'
        );
    }

    public function logout(Request $request): Response
    {
        $this->authService->logout($request->user());

        return $this->noContent();
    }

    public function logoutAll(Request $request): Response
    {
        $this->authService->logoutAll($request->user()->id);

        return $this->noContent();
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
