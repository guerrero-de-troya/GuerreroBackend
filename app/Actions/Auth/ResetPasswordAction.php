<?php

namespace App\Actions\Auth;

use App\Data\Auth\ResetPasswordData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordAction
{
    /**
     * @return array{success: bool, message: string, statusCode: int}
     */
    public function execute(ResetPasswordData $data): array
    {
        $status = Password::reset(
            [
                'email' => strtolower($data->email),
                'password' => $data->password,
                'password_confirmation' => $data->passwordConfirmation,
                'token' => $data->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
                $user->tokens()->delete();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? [
                'success' => true,
                'message' => 'Contraseña restablecida exitosamente.',
                'statusCode' => 200,
            ]
            : [
                'success' => false,
                'message' => 'El token es inválido o ha expirado.',
                'statusCode' => 400,
            ];
    }
}
