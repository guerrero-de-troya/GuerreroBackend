<?php

namespace App\Http\Requests;

use App\Data\Auth\ResetPasswordData;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ResetPasswordData::rules();
    }

    public function messages(): array
    {
        return [
            'token.required' => 'El token es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    public function toDto(): ResetPasswordData
    {
        return ResetPasswordData::from(
            $this->only(['token', 'email', 'password', 'password_confirmation'])
        );
    }
}
