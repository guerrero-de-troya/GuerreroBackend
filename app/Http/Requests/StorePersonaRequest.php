<?php

namespace App\Http\Requests;

use App\Data\Persona\StorePersonaData;
use App\Traits\PersonaValidationMessages;
use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    use PersonaValidationMessages;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return StorePersonaData::rules();
    }

    public function messages(): array
    {
        return self::personaMessages();
    }

    public function toDto(): StorePersonaData
    {
        return StorePersonaData::from($this->validated());
    }
}
