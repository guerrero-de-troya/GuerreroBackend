<?php

namespace App\Http\Requests;

use App\Data\Auth\ForgotPasswordData;
use App\Http\Requests\Traits\NormalizesEmail;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    use NormalizesEmail;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ForgotPasswordData::rules();
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
        ];
    }

    public function toDto(): ForgotPasswordData
    {
        return ForgotPasswordData::from($this->validated());
    }
}
