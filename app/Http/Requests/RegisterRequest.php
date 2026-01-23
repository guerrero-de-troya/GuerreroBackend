<?php

namespace App\Http\Requests;

use App\Data\Auth\RegisterData;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return RegisterData::rules();
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.unique' => 'El email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    public function toDto(): RegisterData
    {
        return RegisterData::from(
            $this->only(['email', 'password', 'password_confirmation'])
        );
    }
}
