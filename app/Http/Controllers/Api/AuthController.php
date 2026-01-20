<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends BaseController
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return $this->created(
            [
                'user' => new UserResource($result['user']),
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
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'Sesión iniciada exitosamente'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()?->currentAccessToken();
        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return $this->success(null, 'Sesión cerrada exitosamente');
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        if ($userId === null) {
            return $this->error('Usuario no autenticado', 401);
        }

        $this->authService->logoutAll($userId);

        return $this->success(null, 'Sesión cerrada en todos los dispositivos');
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();

        if ($user === null) {
            return $this->error('Usuario no autenticado', 401);
        }

        return $this->success(
            new UserResource($user),
            'Usuario obtenido exitosamente'
        );
    }
}
