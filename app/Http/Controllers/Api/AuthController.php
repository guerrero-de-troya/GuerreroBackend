<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Auth Controller
 *
 * Controla las peticiones HTTP relacionadas con autenticación.
 */
class AuthController extends BaseController
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * Registrar un nuevo usuario
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->register($request->validated());

            return $this->created(
                [
                    'user' => new UserResource($result['user']),
                    'token' => $result['token'],
                ],
                'Usuario registrado exitosamente. Por favor verifica tu email.'
            );
        } catch (\Exception $e) {
            return $this->error('Error al registrar usuario: '.$e->getMessage(), 500);
        }
    }

    /**
     * Iniciar sesión
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
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
        } catch (AuthenticationException $e) {
            return $this->error($e->getMessage(), 401);
        } catch (\Exception $e) {
            return $this->error('Error al iniciar sesión: '.$e->getMessage(), 500);
        }
    }

    /**
     * Cerrar sesión (token actual)
     */
    public function logout(): JsonResponse
    {
        try {
            $userId = Auth::id();
            $this->authService->logout($userId);

            return $this->success(null, 'Sesión cerrada exitosamente');
        } catch (\Exception $e) {
            return $this->error('Error al cerrar sesión: '.$e->getMessage(), 500);
        }
    }

    /**
     * Cerrar sesión en todos los dispositivos
     */
    public function logoutAll(): JsonResponse
    {
        try {
            $userId = Auth::id();
            $this->authService->logoutAll($userId);

            return $this->success(null, 'Sesión cerrada en todos los dispositivos');
        } catch (\Exception $e) {
            return $this->error('Error al cerrar sesión: '.$e->getMessage(), 500);
        }
    }

    /**
     * Obtener el usuario autenticado
     */
    public function me(): JsonResponse
    {
        try {
            $userId = Auth::id();
            $user = $this->authService->getAuthenticatedUser($userId);

            return $this->success(
                new UserResource($user),
                'Usuario obtenido exitosamente'
            );
        } catch (\Exception $e) {
            return $this->error('Error al obtener usuario: '.$e->getMessage(), 500);
        }
    }
}
