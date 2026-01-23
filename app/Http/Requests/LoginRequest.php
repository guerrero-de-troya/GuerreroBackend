<?php

namespace App\Http\Requests;

use App\Data\Auth\LoginData;
use App\Http\Requests\Traits\NormalizesEmail;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use NormalizesEmail;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return LoginData::rules();
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }

    public function toDto(): LoginData
    {
        return LoginData::from($this->validated());
    }
}
