<?php

namespace App\Http\Requests;

use App\Data\Persona\UpdatePersonaData;
use App\Traits\PersonaValidationMessages;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
{
    use PersonaValidationMessages;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $personaId = $this->route('persona');

        return UpdatePersonaData::rules($personaId);
    }

    public function messages(): array
    {
        return self::personaMessages();
    }

    public function toDto(): UpdatePersonaData
    {
        return UpdatePersonaData::from($this->validated());
    }
}
