<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Verificar que el ID de la ruta coincide con el usuario autenticado
        if (! hash_equals(
            (string) $this->route('id'),
            (string) $this->user()->getKey()
        )) {
            return false;
        }

        // Verificar que el hash coincide con el email del usuario
        if (! hash_equals(
            (string) $this->route('hash'),
            sha1($this->user()->getEmailForVerification())
        )) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
