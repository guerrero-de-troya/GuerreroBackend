<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\LogoutAllAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        if (!$result->success) {
            return match ($result->reason) {
                'email_already_exists' => $this->error('El email ya está registrado.', 422),
                default => $this->error('Error desconocido.', 500),
            };
        }

        return $this->created(
            data: (new UserResource($result->user))->withToken($result->token),
            message: 'Usuario registrado exitosamente. Por favor verifica tu email.'
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->loginAction->execute($request->toDto());

        if (!$result->success) {
            return match ($result->reason) {
                'invalid_credentials' => $this->error('Credenciales inválidas.', 401),
                'email_not_verified' => $this->error('Debes verificar tu email antes de iniciar sesión.', 403),
                default => $this->error('Error desconocido.', 500),
            };
        }

        return $this->success(
            data: (new UserResource($result->user))->withToken($result->token),
            message: 'Sesión iniciada exitosamente'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->logoutAction->execute($request->user());

        return $this->success(message: 'Sesión cerrada exitosamente');
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $this->logoutAllAction->execute($request->user());

        return $this->success(message: 'Todas las sesiones cerradas exitosamente');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load('persona');

        return $this->success(
            data: new UserResource($user),
            message: 'Usuario obtenido exitosamente'
        );
    }
}
